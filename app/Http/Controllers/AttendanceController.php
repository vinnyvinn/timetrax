<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Employee;
use App\Http\Requests\AttendanceRequest;
use App\Role;
use App\Site;
use App\Setting;
use Illuminate\Http\Request;
use Handlers\MiscOperations;
use Auth;
use Carbon\Carbon;
use App\Http\Requests;
use Response;
use Session;
use TA\Managers\AttendanceManager;
use TA\Managers\OvertimeManager;
use TA\Managers\Supervisor;

class AttendanceController extends Controller
{
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
        return view('attendance.create')->with(
            'employees',
            Employee::all(['id', 'first_name', 'last_name', 'payroll_number']))->with('attendance');
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
        $data = $request->all();
        $data['time_in'] = Carbon::parse($data['time_in'])->format('H:i:s');
        if (array_key_exists('time_out', $data)) {
            $data['time_out'] = Carbon::parse($data['time_out'])->format('H:i:s');
        }

        $data['day'] = Carbon::parse($data['day'])->format('Y-m-d');
        $employee = Employee::with(['shifts'])->findOrFail($request->get('employee_id'));
        $attendance = $employee->attendance()->create($data);

        $attendance->clocked_minutes = OvertimeManager::getClockedMinutes($attendance);
        $attendance->overtime_minutes = OvertimeManager::calculate($employee->shifts->first(), $attendance);
        $attendance->save();

        flash('You have successfully created a new attendance');

        return redirect()->route('attendance.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
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
