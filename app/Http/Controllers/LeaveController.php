<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\LeaveRequest;
use App\Leave;
use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Session;
use App\LeaveType;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!hasPermission(Role::PERM_LEAVE_VIEW_ALL) && !hasPermission(Role::PERM_LEAVE_VIEW_INDIVIDUAL)) {
            abort(403);
        }

        $leave = Leave::with(['employee','leaveType'])
            ->when((hasPermission(Role::PERM_ATTENDANCE_VIEW_INDIVIDUAL) && Auth::user()->employee != null), function ($query) {
                return $query->where('employee_id', Auth::user()->employee->id);
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

//        dd(Leave::all());

        $employeeId = Auth::user()->employee == null ? 0 : Auth::user()->employee->id;

        return view('leave.index')
            ->with('employee_id', $employeeId)
            ->with('leaves', $leave);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission(Role::PERM_LEAVE_ADD)) {
            abort(403);
        }
        $leavescats=LeaveType::get();

        return view('leave.create',['leavescats'=>$leavescats])->with('employees', Employee::all(['id', 'first_name', 'last_name', 'payroll_number']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveRequest $request)
    {
        if (!hasPermission(Role::PERM_LEAVE_ADD)) {
            abort(403);
        }

        $startDate = Carbon::parse($request->get('start_date'));
        $endDate = Carbon::parse($request->get('end_date'));

        $currentLeave = Leave::where('employee_id', $request->get('employee_id'))
            ->where('start_date', '<=', $startDate->toDateString())
            ->where('end_date', '>=', $startDate->toDateString())
            ->exists();

        if ($currentLeave) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['employee_id' => 'Sorry, the employee already has a leave within those days']);
        }


        Leave::create([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'days' => Carbon::parse($request->get('end_date'))->diffInDays($startDate),
            'employee_id' => $request->get('employee_id'),
            'leave_category' => $request->get('leave_cat'),
            'status' => Leave::STATUS
        ]);
        flash('You have successfully created a new leave');

        return redirect()->route('leave.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leave = Leave::with(['employee'])->findOrFail($id);

        return view('leave.show')->withDetails($leave)
            ->withLeaves(Leave::all(['employee_id']))
            ->withEmployees(Employee::all(['id', 'payroll_number', 'first_name', 'last_name']));
//        dd($leave);

    }

    /**
     * Show the form for editing the specified resource.
     *>withLeaves(Leave::all(['employee_id']))
     * ->withEmployees(Employee::all(['id','payroll_number','first_name', 'last_name']))
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (!hasPermission(Role::PERM_LEAVE_EDIT)) {
            abort(403);
        }

        $leave = Leave::findOrFail($id);

        if ($leave->status != Leave::STATUS) {
            flash('Sorry, the leave request has already been processed.', 'error');

            return redirect()->route('leave.index');
        }

        if ($request->has('q')) {
            if (! hasPermission(Role::PERM_LEAVE_EDIT)) {
                abort(403);
            }

            if (Auth::user()->name != 'Admin' && Auth::user()->employee->id == $leave->employee_id) {
                abort(403);
            }
        }

        return view('leave.edit')->withDetails($leave)
            ->withProcessing($request->has('q'))
            ->withLeaves(Leave::all(['employee_id']))
            ->withEmployees(Employee::all(['id', 'payroll_number', 'first_name', 'last_name']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!hasPermission(Role::PERM_LEAVE_EDIT)) {
            abort(403);
        }

        $data = $request->all();
//        dd($data);
        $leave = Leave::with('employee')->findOrFail($id);
        $leave->update($data);

        flash('You have successfully updated leave');
        return redirect()->route('leave.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Leave $leave
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Leave $leave)
    {
        if (!hasPermission(Role::PERM_LEAVE_DELETE)) {
            abort(403);
        }

        $leave->delete();

        flash('You have successfully deleted the leave');
        return redirect()->route('leave.index');
    }
}
