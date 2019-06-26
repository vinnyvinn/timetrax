<?php

namespace App\Http\Controllers;

use App\company;
use App\Employee;
use App\Http\Requests\EmployeeRequest;
use App\Role;
use App\Shift;
use App\User;
use Carbon\Carbon;
use Faker;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Session;
use TA\Managers\AttendanceManager;
use TA\Managers\OvertimeManager;
use Validator;
use App\EmployeeSite;
use Excel;
use App\HREmployee;
use App\Site;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!hasPermission(Role::PERM_EMPLOYEE_VIEW_ALL)) {
            abort(403);
        }

        $search = request('search');

        $query = Employee::when($search, function ($query) use ($search) {
            return $query->where('payroll_number', 'LIKE', '%' . $search . '%')
                ->orWhere('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%');
        });

        $employee = (hasPermission(Role::PERM_COMPANY_VIEW_ALL)) ?
            $query->paginate(request('paginate')) :
            $query->where('company_id', \Auth::user()->employee->company->id)->paginate(request('paginate'));

        return view('employee.index')->with('employees', $employee);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $shift = Shift::with(['id', 'name', 'day', 'shift_start', 'shift_end']);
//        dd($shift);
        if (Shift::count() < 1) {
            flash('You must create a shift first', 'error');
            return redirect()->route('shift.index');
        }
        if(Role::count() < 1) {
            flash('You must create a role first', 'error');
            return redirect()->route('role.index');
        }
        if (company::count() < 1) {
            flash('You must create a company first', 'error');
            return redirect()->route('company.index');
        }
        $sites = Site::all();

//        dd($sites);

        return view('employee.create')
            ->withRoles(Role::all(['id', 'name']))
            ->withSites($sites)
            ->with('employee', Employee::all(['id', 'payroll_number', 'first_name', 'last_name']))
            ->withShifts(Shift::all(['id', 'name']))
            ->with('companies', company::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
//        dd($data);
        $data['sites_id'] = json_encode($data['sites_id']);
        $data['password'] = bcrypt('password');
        $data['shift_id'] = [$data['shift_id']];
        $data['category_id'] = 1;


        Validator::make($data, [
            'name' => 'required|max:255',
            'payroll_number' => 'required|unique:employees',
            'email' => 'required|email|max:255|unique:users',
            'id_number' => 'required|max:10|unique:employees',
        ])->validate();

        $user = User::create($data);
        $data['user_id'] = $user->id;



        $employee = Employee::create($data);

        $employeesites = new EmployeeSite();
        $employeesites->employee_id = $employee->id;
        $employeesites->sites_id = $data['sites_id'];
        $employeesites->save();
        $employeesites->save();

        $employee->shifts()->sync($data['shift_id']);
       

        flash('You have successfully created a new employee');

        return redirect()->route('employee.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::with('user')->findOrFail($id);
        if($employee->sites != null){
            $sites = json_decode($employee->sites->sites_id);
        }else{
            $sites = NULL;
        }
        // dd(json_decode($employee->sites->sites_id));
        return view('employee.show')->withDetails($employee)
            ->withRoles(Role::all(['id', 'name']))
            ->withUsers(User::all(['id', 'name', 'email']))
            ->withShifts(Shift::all(['id', 'name']))
            ->withEmployeesites($sites)
            ->withSites(Site::all())
            ->with('companies', company::all());
        //dd($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::with(['user'])->findOrFail($id);
        $employee->assigned_shifts = $employee->shifts->map(function ($shift) {
            return $shift->id;
        })->toArray();
        // dd($employee->sites->sites_id);

//        dd(Role::all(['id', 'name']), $employee);

        $sites  = $employee->sites;

        if($sites != null)
        {
            return view('employee.edit')
                ->withDetails($employee)
                ->withRoles(Role::all(['id', 'name']))
                ->withUsers(User::all(['id', 'name', 'email']))
                ->withSites(Site::all())
                ->withEmployeesites(json_decode($employee->sites->sites_id))
                ->withShifts(Shift::all(['id', 'name']))
                ->with('companies', company::all());
        }else{

            return view('employee.edit')
                ->withDetails($employee)
                ->withRoles(Role::all(['id', 'name']))
                ->withUsers(User::all(['id', 'name', 'email']))
                ->withSites(Site::all())
                ->withEmployeesites(null)
                ->withShifts(Shift::all(['id', 'name']))
                ->with('companies', company::all());
        }

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

        
        $data = $request->all();
        $data['shift_id'] = [$data['shift_id']];

        Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'payroll_number' => 'unique:employees',
            'id_number' => 'max:10|unique:employees',
        ])->validate();

        $employee = Employee::with('user')->findOrFail($id);

        $employeesites = EmployeeSite::where('employee_id', $id)->first();

        if($employeesites == null)
        {
            $site = new EmployeeSite();
            $site->employee_id = $employee->id;
            $site->sites_id = json_encode($request->sites_id);
            $site->save();
        }else{
            $employeesites->sites_id = json_encode($request->sites_id);
            $employeesites->save();
        }

        $employee->update($data);
        if($employee->user)
        {
            $employee->user->update($data);
        }
        $employee->shifts()->sync($data['shift_id']);

        flash('You have successfully edited the employee');
        return redirect()->route('employee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Employee $employee)
    {
        $employee->leave()->delete();
        $employee->attendance()->delete();
//        $employee->overtime()->delete();
        $employee->delete();
        $employee->user()->delete();

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attendance()
    {
        $employees = Employee::all();
        $sites = Site::all();
        $day = Carbon::now()->format('Y-m-d');

        return view('employee.attendance.create', compact('employees', 'day', 'sites'));

    }

    private function validateSignOut($attendance, $shift)
    {
        if ($attendance->day == Carbon::now()->format('Y-m-d')) {
            return true;
        }


        $shift->day = json_decode($shift->day);
        $attendedDay = Carbon::parse($attendance->day)->format('l');
        $today = Carbon::now()->format('l');

        if (! in_array($today, $shift->day) && ! in_array($attendedDay, $shift->day)) {
            return true;
        }

        if (! in_array($attendedDay, $shift->day) && in_array($today, $shift->day)) {
            $shiftDifference = Carbon::parse('01-01-2017 ' . $shift->shift_end)
                ->diffInMinutes(Carbon::parse('01-01-2017 ' . $shift->shift_start));

            $attendance->time_out = Carbon::parse($attendance->day . ' ' . $attendance->time_in)->addMinutes(
                $shiftDifference);
            $attendance->save();

            return false;
        }

        if (in_array($attendedDay, $shift->day) && ! in_array($today, $shift->day)) {
            return true;
        }

        if (in_array($attendedDay, $shift->day) && in_array($today, $shift->day)) {
            $attendance->time_out = $shift->shift_end;
            $attendance->save();
        }

        return false;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAttendance(Request $request)
    {
        $data = $request->all();

        $employee = Employee::findOrFail($request->employee_id);
        $shifts = $employee->shifts->first();

        $lastCheckIn = $employee->attendance
            ->sortByDesc('id')
            ->first();

        if ($lastCheckIn != null && is_null($lastCheckIn->time_out)) {
            if ($this->validateSignOut($lastCheckIn, $shifts)) {
                $lastCheckIn->time_out = Carbon::now()->toTimeString();
                $lastCheckIn->update([
                    'time_out' => Carbon::now(),
                    'clocked_minutes' => OvertimeManager::getClockedMinutes($lastCheckIn),
                    'overtime_minutes' => OvertimeManager::calculate($shifts, $lastCheckIn)
                ]);

                flash('Successfully checked out.');

                //AttendanceManager::calculateOvertimeHours(Carbon::now(), Auth::user()->employee->id);

                return request()->ajax() ?
                    $this->sendVueResponse() :
                    redirect()->route('attendance.index');
            }
        }

        $data['day'] = Carbon::now()->format('Y-m-d');
        $data['time_in'] = Carbon::now()->format('H:i:s');
        // $data['site_id'] = Carbon::now()->format('H:i:s');
        $employee->attendance()->create($data);

        flash('Successfully checked in.');

        return redirect()->route('attendance.index');
    }

    public function validateReady(){
         if (Shift::count() < 1) {
            flash('You must create a shift first', 'error');
            return redirect()->route('shift.index');
        }
        if(Role::count() < 1) {
            flash('You must create a role first', 'error');
            return redirect()->route('role.index');
        }
        if (company::count() < 1) {
            flash('You must create a company first', 'error');
            return redirect()->route('company.index');
        }

        return ;
    }
    public function import(){

            $this->validateReady();

            return view('employee.import');
    }

    public function importHR() 
        {

            $import=new HREmployee();

            if($import->handle()){
                    return response()->json("success");

            }else{
                    return response()->json("an error occured");
            }
        
        }

    public function importCSV(Request $request){
        if (! $request->hasFile('csv_file')) {
            flash('Please select a file to upload first','error');
            return redirect()->route('employee.index');
        }
        $file = $request->file('csv_file');
        $excel = \Excel::load($file)->get()->toArray();
        //$excel = count($excel) ? $excel[0] : [];
        if ($excel == null) {
            flash('The file you selected is empty please select another one', 'error');
            return redirect()->back();
        }
        $expectedColumns = 4;
        $sampleProduct = $excel[0];
        if (count(array_keys($sampleProduct)) > $expectedColumns) {
            flash('The file you uploaded did not match the expected format, Please upload a new one', 'error');
            return redirect()->back();
        }
        $existing = Employee::all(['payroll_number'])->map(function ($stockItem) {
            return $stockItem->payroll_number;
        })->toArray();
       
        $excel = array_map(function ($item) use ($existing) {
            $values = array_values($item);
            if (in_array($values[3], $existing)) {
                return null;
            }
            return [
                'first_name' => $values[0],
                'last_name' => $values[1],
                'email' => $values[2],
                'payroll_number' => $values[3],                
            ];
        }, $excel);
        $excel = array_filter($excel, function ($item) {
            return ! is_null($item);
        });
        foreach ($excel as $item) {
            $user = new User();
            $user->email=$item['email'];
            $user->password=bcrypt($request->password);
            $user->name=$item['first_name']." ".$item['last_name'];
            $user->role_id=1;
            $user->save();
            $lastID=$user->id;
            
            $newEmployee=new Employee();
            $newEmployee->user_id=$lastID;
            $newEmployee->company_id=1;
            $newEmployee->payroll_number=$item['payroll_number'];
            $newEmployee->first_name=$item['first_name'];
            $newEmployee->last_name=$item['last_name'];
            $newEmployee->save();
        }

        flash('Successfully imported items', 'success');
        return redirect()->back();
    }
    
}
