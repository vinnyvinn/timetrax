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
// use Illuminate\Http\Request;

class ExceptionReportController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //dd(Supervisor::punchCard(Employee::first(), Carbon::now()));


        if (! hasPermission(Role::PERM_ATTENDANCE_VIEW_INDIVIDUAL) && ! hasPermission(Role::PERM_ATTENDANCE_VIEW_ALL)) {
            abort(403);
        }

        if (isset($request->from) && isset($request->to)) {
            $attendance = Attendance::with(['employee.user'])
                ->when(
                    (hasPermission(Role::PERM_ATTENDANCE_VIEW_INDIVIDUAL) && Auth::user()->employee != null),
                    function ($query) {
                        return $query->where('employee_id', Auth::user()->employee->id);
                    }
                )
                ->where('day', '>=', Carbon::parse($request->from)->format('Y-m-d'))
                ->where('day', '<=', Carbon::parse($request->to)->format('Y-m-d'))
                ->orderBy('id', 'desc')
                ->get();

            if (request()->ajax()) {
                return Response::json($attendance);
            }

            $checkingIn = Auth::user()->employee == null ?
                true :
                Auth::user()->employee->attendance->where('time_out', null)->count() > 0;

            return view('attendance.index')
                ->with('checkin', $checkingIn)
                ->with('attendances', $attendance)
                ->with('params', [
                    'to' => Carbon::parse($request->to),
                    'from' => Carbon::parse($request->from)
                ]);
        } else {
            $attendance = Attendance::with(['employee.user'])
                ->when(
                    (hasPermission(Role::PERM_ATTENDANCE_VIEW_INDIVIDUAL) && Auth::user()->employee != null),
                    function ($query) {
                        return $query->where('employee_id', Auth::user()->employee->id);
                    })
                ->where('day', Carbon::now()->format('Y-m-d'))
                ->orderBy('id', 'desc')
                ->paginate(15);

            if (request()->ajax()) {
                return Response::json($attendance);
            }

            $checkingIn = Auth::user()->employee == null ? true : Auth::user()->employee->attendance->where(
                    'time_out',
                    null)->count() > 0;

            $sites = Site::all();

            return view('attendance.index')
                ->with('checkin', $checkingIn)
                ->with('sites', $sites)
                ->with('attendances', $attendance);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('reports.exception.create')->with('employees', Employee::all())
            ->with('shifts', Shift::all(['id', 'name']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $attendances = $this->getAttendances($request);
         // dd($attendances);
        if ($request->get('format') == 'pdf') {
            return $this->createPDF($request, $attendances);
        }

        return $this->createExcel($request, $attendances);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
     protected function getAttendances(Request $request)
    {
        $attendances = Attendance::with('employee.shifts')
            ->when($request->employee_id != 'all', function ($query) use ($request) {
                    return $query->where('employee_id', $request->get('employee_id'));
            })
            ->where('day', '>=', Carbon::parse($request->get('start_date'))->startOfDay())
            ->where('day', '<=', Carbon::parse($request->get('end_date'))->endOfDay())
            ->where('time_out', null)
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

    public function show($id)
    {
        $employee = Auth::user()->employee;

        if (! Supervisor::punchCard($employee, Carbon::now())) {
            flash('Sorry, you cannot check in again.', 'error');

            return request()->ajax() ? $this->sendVueResponse() : redirect()->back();
        }

        flash('Successfully entered card.');

        return request()->ajax() ? $this->sendVueResponse() : redirect()->back();
    }

    private function sendVueResponse()
    {
        $attendance = Attendance::with(['employee'])
            ->where('employee_id', Auth::user()->employee->id)
            ->orderBy('id', 'desc')
            ->get();

        return Response::json($attendance);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
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

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    public function register()
    {
        return null;
    }

    public function attendanceData(Request $request)
    {
        return Attendance::where('employee_id', $request->id)
            ->get()
            ->map(
                function ($value) {
                    return [
                        'day'        => $value->day,
                        'time_in'    => $value->time_in,
                        'time_out'   => $value->time_out,
                        'time_taken' => MiscOperations::calculateMinsHours(
                            Carbon::parse($value->time_in)->diffInMinutes(Carbon::parse($value->time_out)))
                    ];
                })
            ->toJson();
    }

}
