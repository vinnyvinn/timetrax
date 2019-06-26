<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Employee;
use App\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceSummaryReportController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('reports.attendanceSummary.create')->with('employees', Employee::all())->with('shifts', Shift::all());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $attendances = Attendance::with('employee.shifts')
            ->when($request->employee_id != 'all', function ($query) use ($request) {
                return $query->where('employee_id', $request->get('employee_id'));
            })
            ->where('day', '>=', Carbon::parse($request->get('start_date'))->startOfDay())
            ->where('day', '<=', Carbon::parse($request->get('end_date'))->endOfDay())
            ->get()
            ->groupBy('employee_id');

        $attendances = $attendances->map(function ($attendance) {
            $summary = new \stdClass();
            $employee = $attendance->first()->employee;

            $summary->first_name = $employee->first_name;
            $summary->last_name = $employee->last_name;
            $summary->payroll_number = $employee->payroll_number;
            $summary->shifts = $employee->shifts->map(function ($shift) {
                return $shift->name;
            })->toArray();

            $totalHours = 0;

            foreach ($attendance as $record) {
                $totalHours += round((Carbon::parse('01-01-2016 ' . $record->time_in)
                        ->diffInMinutes(Carbon::parse('01-01-2016 ' . $record->time_out)))/60, 2);
            }

            $summary->totalHours = $totalHours;

            return $summary;
        })->toArray();

        Excel::create('Attendance', function ($excel) use ($attendances, $request)
        {
            $excel->sheet('New sheet', function ($sheet) use ($attendances, $request)
            {
                $sheet->loadView('reports.attendanceSummary.report')
                    ->with('start_date', $request->get('start_date'))
                    ->with('end_date', $request->get('end_date'))
                    ->withAttendances($attendances);
            });
        })->download($request->get('format'));
    }
}
