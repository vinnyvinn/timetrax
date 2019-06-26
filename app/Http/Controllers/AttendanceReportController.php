<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Shift;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Attendance;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests;

class AttendanceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('reports.attendance.create')->with('employees', Employee::all())
            ->with('shifts', Shift::all(['id', 'name']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attendances = $this->getAttendances($request);

        if ($request->get('format') == 'pdf') {
            return $this->createPDF($request, $attendances);
        }

        return $this->createExcel($request, $attendances);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    protected function getAttendances(Request $request)
    {
        $attendances = Attendance::with('employee.shifts')
            ->when($request->employee_id != 'all', function ($query) use ($request) {
                    return $query->where('employee_id', $request->get('employee_id'));
            })
            ->where('day', '>=', Carbon::parse($request->get('start_date'))->startOfDay())
            ->where('day', '<=', Carbon::parse($request->get('end_date'))->endOfDay())
            ->get();

        $attendances = $attendances->map(function ($attendance) {
            $employee = $attendance->employee;
            $shift = $employee->shifts->first();
            unset($attendance->employee);

            $attendance->payroll_number = $employee->payroll_number;
            $attendance->first_name = $employee->first_name;
            $attendance->last_name = $employee->last_name;
            $attendance->shiftName = ucwords($shift->name);
            $attendance->shiftDays = is_array($shift->day) ? $shift->day : json_decode($shift->day);
            $attendance->shiftHours = (Carbon::parse('01-01-2017 ' . $shift->shift_start)
                ->diffInMinutes(Carbon::parse('01-01-2017 ' . $shift->shift_end))) / 60;

            return $attendance;
        });

        return $attendances;
    }

    /**
     * @param Request $request
     * @param         $attendances
     *
     * @return mixed
     */
    protected function createPDF(Request $request, $attendances)
    {
        header('Content-Type', 'application/pdf');
        header('Content-Disposition', 'inline; filename="Attendance.pdf"');

        return PDF::loadHTML(
            view('reports.attendance.report')
                ->with('hasWidth', true)
                ->with('startDate', Carbon::parse($request->get('start_date')))
                ->with('endDate', Carbon::parse($request->get('end_date')))
                ->with('attendances', $attendances))
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->stream('Attendance.pdf', ['attachment' => 0]);
    }

    /**
     * @param Request $request
     * @param         $attendances
     *
     * @return mixed
     */
    protected function createExcel(Request $request, $attendances)
    {
        return Excel::create(
            'Attendance',
            function ($excel) use ($attendances, $request) {
                $excel->sheet(
                    'New sheet',
                    function ($sheet) use ($attendances, $request) {
                        $sheet->loadView('reports.attendance.report')
                            ->with('hasWidth', false)
                            ->with('startDate', Carbon::parse($request->get('start_date')))
                            ->with('endDate', Carbon::parse($request->get('end_date')))
                            ->with('attendances', $attendances);
                    });
            })->download($request->get('format'));
    }
}
