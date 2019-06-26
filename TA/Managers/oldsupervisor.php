<?php

namespace TA\Managers;


use App\Attendance;
use App\Employee;
use App\Holiday;
use App\Overtime;
use App\Setting;
use App\Shift;
use Carbon\Carbon;

/**
 * Class Supervisor
 * @package TA\Managers
 */
class Supervisor {

    /**
     * Punch the employee in or out.
     *
     * @param Employee $employee
     * @param Carbon $time
     * @return Attendance|static
     */
    public static function punchCard(Employee $employee, Carbon $time ,$log = null)
    {
        $lastCard = $employee->attendance()->orderBy('id', 'desc')->first();



        if (self::isCheckingIn($lastCard)) {

            return self::checkIn($employee, $time, $lastCard);

        }

        return self::validateCheckOut($employee, $lastCard, $time,$log);
    }

    /**
     * Validate if the Employee is checking in.
     *
     * @param Attendance $lastCard
     *
     * @return bool
     */
    private static function isCheckingIn($lastCard)
    {

        if (! $lastCard) {

            return true;
        }

        if ($lastCard->time_out) {
            return true;
        }

        return false;
    }

    /**
     * Validate that the Employee is checking out.
     *
     * @param Employee $employee
     * @param Attendance $lastCard
     * @param Carbon $time
     *
     * @return Attendance|static
     */
    private static function validateCheckOut(Employee $employee, $lastCard, Carbon $time, $log)
    {


        $shift = $employee->shifts->first();


        // if ($lastCard->day == $time->format('Y-m-d')) {
        //     return self::checkOut($shift, $lastCard, $time,$log);
        // }
        $time = Carbon::parse($log->ADate);
      if ($lastCard->day == $time->format('Y-m-d') && ($lastCard->time_in == $time->format('H:is'))) {
           return ;
        }else if($lastCard->time_in  != $time->format('H:is')){

             return self::checkOut($shift, $lastCard, $time,$log);

        }else 

        return self::checkIn($employee, $time, $lastCard);
    }

    /**
     * Check the Employee in.
     *
     * @param Employee $employee
     * @param Carbon $time
     * @param Attendance $lastCard
     *
     * @return Attendance|bool
     */
    private static function checkIn(Employee $employee, Carbon $time, $lastCard)
    {
        if (strtoupper(getSetting(Setting::MULTIPLE_CHECKIN_SETTING)) != 'ENABLED' && $lastCard) {
            if ($lastCard->day == $time->format('Y-m-d')) {
                return false;
            }
        }

        return Attendance::create([
            'employee_id' => $employee->id,
            'time_in' => $time,
            'day' => $time,
        ]);
    }

    /**
     * Check the Employee out.
     *
     * @param Shift $shift
     * @param Attendance $attendance
     * @param Carbon $time
     *
     * @return Attendance
     */
    private static function checkOut(Shift $shift, Attendance $attendance, Carbon $time, $log=null)
    {
        $attendance->time_out = $time;
        $attendance->fill([
            'time_out' => $time,
            'overtime_id' => self::getOvertimeType($shift, $time),
            'overtime_minutes' => self::calculateOT($shift, $attendance,$log),
            'clocked_minutes' => self::getClockedShiftMinutes($shift, $attendance,$log,true)
        ]);

        $attendance->save();

        return $attendance;
    }

    /**
     * Get the correct overtime type.
     *
     * @param Shift $shift
     * @param Carbon $time
     *
     * @return mixed
     */
    private static function getOvertimeType(Shift $shift, Carbon $time)
    {
        if (self::isHoliday($time) || ! self::isShiftDay($shift, $time)) {
            return Overtime::special()->id;
        }

        return Overtime::standard()->id;
    }

    /**
     * Get the days the shift is assigned.
     *
     * @param Shift $shift
     * @return mixed
     */
    private static function getShiftDays(Shift $shift)
    {
        return json_decode($shift->day);
    }

    /**
     * Check if the day is a shift day.
     *
     * @param Shift $shift
     * @param Carbon $day
     * @return bool
     */
    public static function isShiftDay(Shift $shift, Carbon $day)
    {
        $day = Carbon::parse($day)->format('l');

        return in_array($day, self::getShiftDays($shift));
    }

    /**
     * Check if the day is a holiday.
     *
     * @param Carbon $day
     * @return bool
     */
    public static function isHoliday(Carbon $day)
    {
        return Holiday::where('month', $day->month)
            ->where('day', $day->day)
            ->count() > 0;
    }

    /**
     * Get the total overtime minutes given the attendance and shift.
     *
     * @param Shift $shift
     * @param Attendance $attendance
     * @return int
     */
    public static function calculateOT(Shift $shift, Attendance $attendance , $log=null)
    {
        $overtime = self::getClockedMinutes($attendance);
        $attendanceDay = Carbon::parse($attendance->day);

        if (self::isShiftDay($shift, $attendanceDay) && ! self::isHoliday($attendanceDay)) {
            $overtime = self::getTotalOvertimeMinutes($shift, $attendance);
        }

        return $overtime;
    }

    /**
     * Get the total clocked minuted from the attendance.
     *
     * @param Attendance $attendance
     * @return int
     */
    private static function getClockedMinutes(Attendance $attendance)
    {
        return Carbon::parse($attendance->day . ' ' . $attendance->time_out->toTimeString())
                ->diffInMinutes(Carbon::parse($attendance->day . ' ' . $attendance->time_in));
    }

    /**
     * Get the total of overtime and undertime in minutes.
     *
     * @param Shift $shift
     * @param Attendance $attendance
     * @return int
     */
    private static function getTotalOvertimeMinutes(Shift $shift, Attendance $attendance)
    {
        return self::getOvertime($shift, $attendance) + self::getUndertime($shift, $attendance);
    }

    /**
     * Calculate the total minutes from the end of the shift.
     *
     * @param Shift $shift
     * @param Attendance $attendance
     * @return int
     */
    private static function getOvertime(Shift $shift, Attendance $attendance)
    {
        if (strtoupper(Setting::value(Setting::OVERTIME_SETTING)) != 'ENABLED') {
            return 0;
        }

        $shiftEnd = Carbon::parse($shift->shift_end);
        $timeOut = Carbon::parse($attendance->day . ' ' . $attendance->time_out->toTimeString());
        $timeIn = Carbon::parse($attendance->day . ' ' . $attendance->time_in);

        if ($shiftEnd->lt($timeIn)) {
            return $timeIn->diffInMinutes($timeOut);
        }

        if ($timeOut->gt($shiftEnd)) {
            return $timeOut->diffInMinutes($shiftEnd);
        }

        return 0;
    }

    /**
     * Calculate the total minutes before the start of the shift.
     *
     * @param Shift $shift
     * @param Attendance $attendance
     * @return int
     */
    private static function getUndertime(Shift $shift, Attendance $attendance)
    {
        if (strtoupper(Setting::value(Setting::UNDERTIME_SETTING)) != 'ENABLED') {
            return 0;
        }

        $undertime = 0;
        $shiftStart = Carbon::parse($shift->shift_start);
        $timeIn = Carbon::parse($attendance->day . ' ' . $attendance->time_in);

        if ($timeIn->lt($shiftStart)) {
            $undertime = $timeIn->diffInMinutes($shiftStart);
        }

        return $undertime;
    }

    private static function getClockedShiftMinutes($shift, $attendance, $log = null, $checkout =false)
    {

        dd($checkout);

        
            if($checkout){
                dd($log);

            }
          dd('not checkout');


        $shiftEnd = Carbon::parse($shift->shift_end);
        $shiftStart = Carbon::parse($shift->shift_start);
        $timeOut = $checkout ? Carbon::parse($log->ADate) : Carbon::parse($attendance->day . ' ' . $attendance->time_out->toTimeString());
        $timeIn = Carbon::parse($attendance->day . ' ' . $attendance->time_in);


        if ($timeIn->gte($shiftEnd)) {
            return 0;
        }

        if ($timeIn->lt($shiftStart)) {
            $timeIn = $shiftStart;
        }

        if ($timeOut->gt($shiftEnd)) {
            $timeOut = $shiftEnd;
        }

        $imecalc = $timeOut->diffInMinutes($timeIn);

        dd($imecalc);
        return $imecalc;
    }
}
