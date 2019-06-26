<?php
/**
 * Created by PhpStorm.
 * User: koi
 * Date: 10/26/16
 * Time: 1:36 PM
 */

namespace TA\Managers;


use App\Attendance;
use App\Employee;
use App\EmployeeOvertime;
use App\Shift;
use Carbon\Carbon;
use App\Holiday;
use App\AttendanceLog;
use App\Setting;
use App\TA_LOG;
use Exception;
use Illuminate\Support\Facades\Auth;

class AttendanceManager
{
    /**
     * Get the employees attendance by a given day.
     *
     * @param Employee $employee
     * @param Carbon $date
     * @return mixed
     */
    public static function getAttendanceByDay(Employee $employee, Carbon $date)
    {
        return $employee->attendance()->where('day', $date->format('Y-m-d'))->get([
            'employee_id', 'time_in', 'time_out', 'day'
        ]);
    }

    /**
     * Get today's employees attendance.
     *
     * @param Employee $employee
     * @return mixed
     */
    public static function getTodaysAttendance(Employee $employee)
    {
        return self::getAttendanceByDay($employee, Carbon::now());
    }

    /**
     * Get the hours worked in a given day.
     *
     * @param Employee $employee
     * @param Carbon $date
     * @return int
     */
    public static function getWorkedHoursByDay(Employee $employee, Carbon $date)
    {
        $attendances = self::getAttendanceByDay($employee, $date);

        return self::getTotalWorkedHours($attendances);
    }

    /**
     * Get the total worked hours from attendance.
     *
     * @param $attendances
     * @return int
     */
    public static function getTotalWorkedHours($attendances)
    {
        $totalMinutes = 0;

        foreach ($attendances as $attendance) {
            if (!$attendance->time_out) {
                continue;
            }

            $totalMinutes += Carbon::parse($attendance->time_out)->diffInMinutes(Carbon::parse($attendance->time_in));
        }

        return $totalMinutes / 60;
    }

    public static function getShiftsByDay(Employee $employee, Carbon $date)
    {
        $dayOfWeek = self::getDayOfWeek($date);

        return $employee->shifts->reject(function ($shift) use ($dayOfWeek) {
            return ! strpos($shift->day, $dayOfWeek);
        });
    }

    public static function getTotalShiftHours(Shift $shift)
    {
        return (Carbon::parse($shift->shift_end)->diffInMinutes($shift->shift_start)) / 60;
    }

    
    /**
     * Get the day of the week for the given date.
     *
     * @param Carbon $date
     * @return mixed
     */
    public static function getDayOfWeek(Carbon $date)
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return $days[$date->dayOfWeek];
    }


    public function getOvertime(Shift $shift, Attendance $attendance)
    {
        $overtime = 0;
        $shiftEnd = Carbon::parse($shift->shift_end);
        $timeOut = Carbon::parse($attendance->day . ' ' . $attendance->time_out);

        if ($timeOut->gt($shiftEnd)) {
            $overtime = $timeOut->diffInMinutes($shiftEnd);
        }

        return $overtime;
    }


    public function getUndertime(Shift $shift, Attendance $attendance)
    {
        $undertime = 0;
        $shiftStart = Carbon::parse($shift->shift_start);
        $timeIn = Carbon::parse($attendance->day . ' ' . $attendance->time_in);

        if ($timeIn->lt($shiftStart)) {
            $undertime = $timeIn->diffInMinutes($shiftStart);
        }

        return $undertime;
     }


    public static function getOvertimeByDay(Employee $employee, Carbon $date)
    {
        $attendances = $employee->attendance()->where('day', $date)->get();

        dd($attendances);
    }

    public static function getOvertimeByMonth(Employee $employee)
    {
        $monthlyOvertime = self::getOvertimeByDay();

    }


    public static function getHourlyRate($amount, $workingDays, $workingHours)
    {
        return $amount / ($workingDays * $workingHours);
    }

    public static function calculateOvertimeHours($dy, $id) {
        //if overtime for yesterday already exists (already calculated), exit
        if(EmployeeOvertime::where('day', Carbon::parse($dy)->subDay()->format('Y-m-d'))){
            return;
       }

        //fetch attendances for the particular employee
        $attendance = Employee::with(['attendance' => function ($query) use($dy) {
            $query->select(['employee_id', 'time_in', 'time_out', 'day'])
                ->where('day', Carbon::parse($dy)->subDay()->format('Y-m-d'))
                ->orderBy('time_out', 'asc');
        }])->where('id', $id)->get();

        //if there is no attendance from yesterday, no overtime to calculate therefore exit
        if($attendance->first()->attendance->count() < 1) {
            return;
        }

        //fetch shifts
        $shifts = Employee::with(['shifts' => function($query) {
            $query->orderBy('shift_end', 'asc');
        }])->where('id', $id)->get()->first();

        //fetch settings (standard and special overtimes types and rates) and holidays
        $holidays = Holiday::get()->keyBy('name')->map(function($value) {
            return $value->day."-".$value->month;
        })->toArray();
        $hours = collect();
        $type = '';
        $days = collect();

        //if yesterday is not in the assigned shift or if yesterday was a holiday, overtime type is special
        $shifts->first()->shifts->each(function ($current) use ($days) {
            $days->push($current->day);
        });

        $days = $days->implode("");
        if(!strpos($days, Carbon::yesterday()->format('l')) || in_array(Carbon::yesterday()->format('d-m'), $holidays)) {
            //loop through the attendances
            $attendance->first()->attendance->each(function ($att) use ($hours) {
                //calculate overtime only if time out is not null and the difference between the time out and
                // and time in is greater than one hour
                if(isset($att->time_out) && Carbon::parse($att->time_in)->diffInHours(Carbon::parse($att->time_out)) >= 1) {
                    $hours->push(Carbon::parse($att->time_in)->diffInHours(Carbon::parse($att->time_out)));
                }
            });

            //if overtime hours after calculation is 0, exist; no saving of zero overtime hours
            if($hours->sum() == 0) {
                return;
            }

            //save the overtime hours in the table
            Employee::where('id', $id)->first()->overtime()->create([
                'day' => Carbon::yesterday(), 'type' => 'special', 'hours' => $hours->sum()
            ]);
        } else {
            //overtime type here is standard because yesterday was not a holiday and is in the shift assigned
            //looping through the shifts assigned
            $shifts->first()->shifts->each(function($shift) use ($attendance, $hours) {
                //loop through the attendances
                $attendance->first()->attendance->each(function ($att) use ($shift, $hours) {
                    //if time out is null then exit
                    if(isset($att->time_out)) {
                        //if time out is greater than shift end and their difference is greater than one hour the calculate the overtime
                        if(Carbon::parse($att->time_out)->gt(Carbon::parse($shift->shift_end)) &&
                            Carbon::parse($att->time_out)->diffInHours(Carbon::parse($shift->shift_end)) >= 1) {
                            $hours->push(Carbon::parse($att->time_out)->diffInHours(Carbon::parse($shift->shift_end)));
                        }
                    }
                });
            });
            if($hours->sum() == 0) {
                return;
            }

            //save the overtime hours in the table
            Employee::where('id', $id)->first()->overtime()->create([
                'day' => Carbon::yesterday(), 'type' => 'standard', 'hours' => $hours->sum()
            ]);
        }
    }

    public static function calculateOvertimeAmount() {

    }

    public static function displayOvertimes($startDate, $endDate, $employee) {
        $stDt = Carbon::parse($startDate);
        $edDt = Carbon::parse($endDate);
        $data = EmployeeOvertime::where('employee_id', 'like', "%$employee%")->with('employee')->get();

        if($data->count() == 0) {
            return collect([]);
        }

        return $data->groupBy('employee_id')->map(function($employee) use($stDt, $edDt) {
            $grouped = $employee->groupBy('type');
            $standard = 0;
            $special = 0;
            if(isset($grouped['standard'])) {
                $standard = $grouped['standard']->filter(function ($group) use($stDt, $edDt) {
                    return $group->day >= $stDt && $group->day <= $edDt;
                })->sum('hours');
            }
            if(isset($grouped['special'])) {
                $special = $grouped['special']->filter(function ($group) use($stDt, $edDt) {
                    return Carbon::parse($group->day)->gte($stDt) && Carbon::parse($group->day) ->lte($edDt);
                })->sum('hours');
            }

            return collect(['standard'=>$standard, 'special'=>$special]);
        });
    }

    public static function syncAttendance($attLogs, $log)
    {
       
        try {
            foreach ($attLogs as $att) {
                $employee = Employee::where('payroll_number', $att->EID)->with(['shifts'])->first();

                if($employee){

                Supervisor::punchCard($employee, Carbon::parse($att->ADate),$att);
                
                TA_LOG::where('TAid',$att->TAid)->update(['status' => TA_LOG::DONE]);

                 AttendanceLog::create(['roll_number' => $att->EID, 'date_time_stamp' => $att->ADate]);
                }
             }
            return "success";
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}