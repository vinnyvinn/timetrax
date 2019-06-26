<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Attendance;
use App\Employee;
use App\EmployeeSite;
use App\Site;
use App\Leave;
use App\company;
use App\Role;
use TA\Managers\AttendanceManager;
use TA\Managers\OvertimeManager;
use TA\Managers\Supervisor;
use Carbon\Carbon;
use Validator;
use App\Shift;


class UserController extends BaseController
{

 public function index()
  {
        $managers = User::all();

        return response()->json(['data' => ['managers' => $managers]]);
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // return response()->;
    }
    public function employee_exists($id_num)
    {

    	$employee = Employee::where('id_number', $id_num)->first();

    	if($employee){
    		return response()->json(['data' => ['exists' => 'true', 'employee' => $employee]]);
    	}
    	else{
    		return response()->json(['data' => ['exists' => 'false' ]]);
    	}
    }

    public function register_employee(Request $request)
    {
    		$data = $request->all();
    			// 	$data['id_number'] = $data['id_no'];

    	  // Validator::make($data, [
       //      'id_number' => 'required|unique:employees',
       //  			])->validate();
       $user_C = new User();
       $user_C->email = rand(555, 999999).'@'.rand(555, 99999).'.com';
       $user_C->password = bcrypt('password');
       $user_C->name = $request->f_name;
       $user_C->role_id = 1;
       $user_C->save();

    	  $employee = new Employee();
    	  $employee->first_name = $request->f_name;
        $employee->last_name = $request->l_name;
        $employee->payroll_number = rand(10, 5000);
        $employee->user_id = $user_C->id;
        $employee->category_id = $request->category_id;
        $employee->company_id = $request->company_id;
        $employee->id_number = $request->id_no;
        $employee->image = $request->image;

        // $shift = Shift::first();
        // // return response()->json(['data' => ['message' => $employee]]);
        // $data['shift_id'] = $shift->id;
        $employee->save();
        $arr = [];
        $arr = $request->site_id;

            $site = new EmployeeSite();
            $site->employee_id = $employee->id;

            $site->sites_id = json_encode($arr);
            $site->save();


        $shft = DB::table('employee_shifts')->insert(['employee_id' => $employee->id, 'shift_id'  => 1]);


        return response()->json(['data' => ['message' => 'Employee registered successfully!']]);


    }


    public function employee_checkin(Request $request)
    {
    	// var_dump($request);


    	$data = $request->all();
        $data['time_in'] = Carbon::parse($data['time_in'])->format('H:i:s');
        if (array_key_exists('time_out', $data)) {
            $data['time_out'] = Carbon::parse($data['time_out'])->format('H:i:s');
        }


        $data['day'] = Carbon::parse($data['date_in'])->format('Y-m-d');


        $res = Employee::where('id_number', $request->id_no)->first();

        $employee_id = $res->id;


        $employee = Employee::with(['shifts'])->findOrFail($employee_id);

        $attendance = $employee->attendance()->create($data);
        // $attendance->save();

        return response()->json(['data' => ['message' => 'Employee checked in successfully' ]]);
    }
    public function checkout_employee(Request $request)
    {
    	$data = $request->all();
    	 if (array_key_exists('time_out', $data)) {
            $data['time_out'] = Carbon::parse($data['time_out'])->format('H:i:s');
            $emp = Employee::where('id_number', $data['id_no'])->first();
		    $attendance = Attendance::Where('employee_id', $emp->id)
            		->where('day', $data['date_out'])->orderBy('created_at', 'desc')->first();
            if(!$attendance){
            	return response()->json(['data' => ['message' => 'Sorry! Employee not checked in today']]);
            }

            $attendance->time_out = $data['time_out'];
            $attendance->clocked_minutes = OvertimeManager::getClockedMinutes($attendance);
        	$attendance->overtime_minutes = OvertimeManager::calculate($emp->shifts->first(), $attendance);
        	$attendance->save();
        	return response()->json(['data' => ['message' => 'Employee checkedout successfully' ]]);

        }
    }
    public function companies()
    {
        return response()->json(['data' => ['companies' =>  company::all() ]]);
    }

    public function user_sites(Request $request)
    {
        $user = User::find($request->user_id);
        $id = $user->employee->id;
        // dd($id);
        $emp = EmployeeSite::where('employee_id', $id)->first();
        $emps = json_decode($emp->sites_id);
        $sites = [];
        foreach($emps as $emp)
        {
            $site = Site::find($emp);
            array_push($sites, $site);
        }

        return response()->json(['data' => ['sites' => $sites ]]);

    }

    public function record_leave(Request $request)
    {
      $employees = Employee::all();


      $actual_employees = [];
      foreach($employees as $employee){
        // dd($employee->id);
        $employeesites = EmployeeSite::where('employee_id', $employee->id)->first();

        if($employeesites != null){
          $sitex = json_decode($employeesites->sites_id, true);
          // dd($s÷itex);.
          $tres = $request->site_id;

          if(in_array($tres, $sitex)){

            array_push($actual_employees, $employee);

          }

        }

      }


      return response()->json(['data' => ['employees' => $actual_employees]]);
    }


    public function store_leave(Request $request)
    {
      $startDate = Carbon::now()->toDateString();
      $endDate = Carbon::now()->toDateString();

      // dd($endDate);

      $currentLeave = Leave::where('employee_id', $request->employee_id)
          ->where('start_date', '<=', $startDate)
          ->where('end_date', '>=', $startDate)
          ->exists();


      if ($currentLeave) {
          return response()->json(['data' => ['status' => false,
          'message' => 'Sorry, the employee already has a leave within those days']]);
      }

        Leave::create([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'days' => 1,
            'employee_id' => $request->employee_id,
            'leave_category' => 1,
            'status' => Leave::STATUS
        ]);


      return response()->json(['data' => ['status' => true,
      'message' => 'leave updated successfully']]);

    }
    public function authenticate(Request $request)
    {

        $password = bcrypt($request->password);
//        dd($password);

        $user = User::where('email', $request->email)->first();

        $state = password_verify ( $request->password , $user->password );


        if($state == TRUE)
        {
            $emp = EmployeeSite::where('employee_id', $user->employee->id)->first();
            $emps = json_decode($emp->sites_id);
            $sites = [];
            foreach($emps as $emp)
            {
                $site = Site::find($emp);
                array_push($sites, $site);
            }
//           $sites = $sites->toArray();
            $role = json_decode($user->role->permissions);
           $add_site = in_array(Role::PERM_SITE_ADD, $role );

            return response()->json(['data' => ['status' => 'success', 'add_site' => $add_site,  'user' => $user, 'sites' => $sites]]);

        }else {

            return response()->json(['data' => ['status' => 'not found', 'user' => $user]]);
        }

    }

}
