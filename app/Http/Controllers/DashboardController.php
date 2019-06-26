<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Leave;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Employee;
use App\EmployeeSite;
use App\Site;
use Carbon\Carbon;
use Route;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $to = Carbon::now()->format('Y-m-d');
        $from = Carbon::now()->format('Y-m-d');


          return view('dashboard')
              ->with('employees', Employee::all()->count())
              ->with('attendance', Attendance::all()->count())
              ->with('sites', Site::all())
              ->with('siteselected', 0)
              ->with('totals', $this->find_totals(0))
              ->with('casualcheckin', count($this->findCAttendances(2,0, Carbon::now()->format('Y-m-d'), Carbon::now()->format('Y-m-d'))))
              ->with('casualcheckout', count($this->findcasualCheckoutAttendances(2,0)))
              ->with('staffcheckin', count($this->findAttendances(1, 0)))
              ->with('staffcheckout', count($this->findstaffCheckoutAttendances(1, 0)))
              ->with('intern_checkedin', count($this->findInternAttendaces(3, 0)))
              ->with('leaves', Leave::all()->count());



    }


    public function records(Request $request)
    {

        // $casual


          $site = $request->site_show;
          $to = $request->to;
          $from = $request->from;

          return view('dashboard')
              ->with('employees', $this->count_attendances($site))
              ->with('attendance', count($this->todays_attendace($site, $from, $to)))
              ->with('sites', Site::all())
              ->with('siteselected', $site)
              ->with('totals', $this->find_totals($site))
              ->with('casualcheckin', count($this->findCAttendances(2, $site, $from, $to)))
              ->with('casualcheckout', count($this->findcasualCheckoutAttendances(2, $site)))
              ->with('staffcheckin', count($this->findAttendances(1, $site)))
              ->with('staffcheckout', count($this->findstaffCheckoutAttendances(1, $site)))
              ->with('intern_checkedin', count($this->findInternAttendaces(3, $site)))
              ->with('leaves', count($this->todays_leaves()));

    }
    public function resync()
    {
        $employees = Employee::where('category_id', 2)->get();


        foreach($employees as $employee)
        {
            $employeesites = EmployeeSite::where('employee_id', $employee->id)->first();
            if(!$employeesites){
                $site = new EmployeeSite();
                $site->employee_id = $employee->id;

                $site->sites_id = '["16"]';
                $site->save();
            }
        }
    }
    public function find_totals($site)
    {
        $emps = [];
        $emp['perm'] = 0;
        $emp['temp'] = 0;
        $emp['intern'] = 0;
        $employees = Employee::all();
        // dd($employees);

            if($site != 0){
                foreach ($employees as $key => $employee) {
                    //   // code...
                    $sites = EmployeeSite::where('employee_id', $employee->id)
                    ->first();
                    if($sites){
                        $site_Arr = json_decode($sites['sites_id']);

                        if(!empty($site_Arr)){
                        foreach ($site_Arr as $key => $s) {
                            // code...
                            if($s == $site){
                                if($employee->category_id == 1)
                                {
                                    $emp['perm']++;
                                }
                                if($employee->category_id == 2){
                                    $emp['temp']++;
                                }
                                if($employee->category_id == 3 ){
                                    $emp['intern']++;
                                }

                            }
                            }
                        }
                    }
                }
            }else{
                foreach ($employees as $key => $employee) {
                            // code...

                                if($employee->category_id == 1)
                                {
                                    $emp['perm']++;
                                }
                                if($employee->category_id == 2){
                                    $emp['temp']++;
                                }
                                if($employee->category_id == 3 ){
                                    $emp['intern']++;
                                }


                            }



            }
            return $emp;

    }

    public function findInternAttendaces($site)
    {
      if($site == 0)
      {
          $att = Employee::with(['attendance'=> function($b)
          {
              return $b->whereDate('day', '>=', Carbon::now()->format('Y-m-d'))
                        ->whereDate('day', '<=', Carbon::now()->format('Y-m-d'))
                      ->where('time_in' , '!=' , null);
          }])->where('category_id', 3)->get();

          $actual = $att->reject(function($attendance){
              return !count($attendance->attendance);
          });
          return $actual;
      }else
      {

        $att = Employee::with(['attendance'=> function($b)
        {
            return $b->whereDate('day', '>=', Carbon::parse($_POST['from'])->format('Y-m-d'))
                    ->whereDate('day', '<=', Carbon::parse($_POST['to'])->format('Y-m-d'))
                    ->where('time_in' , '!=' , null)
                    ->where('site_id' , $_POST['site_show']);
        }])->where('category_id', 3)->get();

        $actual = $att->reject(function($attendance){
            return !count($attendance->attendance);
        });

        return $actual;

      }
    }



    public function todays_leaves()
    {
        $val = Leave::where('start_date', Carbon::now()->toDateString())->get();
        return $val;

    }

    public function todays_attendace($site, $from, $to)
    {
        $val = Attendance::whereDate('day', '>=', Carbon::parse($from)->format('Y-m-d'))
                        ->whereDate('day', '<=', Carbon::parse($_POST['to'])->format('Y-m-d'))
                        ->where('time_in', '!=', null)
                        ->where('site_id', $site)->get();

                        return $val;

    }
    public function count_attendances($site)
    {

      $num = 0;
      $site_Arr = array();

      $att = Employee::with(['attendance'=> function($b)
          {
              return $b->whereDate('day', Carbon::now()->format('Y-m-d'))
                      ->where('time_in' , '!=' , null);
          }])->get();

          $actual = $att->reject(function($attendance){
              return !count($attendance->attendance);
          });
          return count($actual);

    }

    public function findPresent($site)
    {

      //find number of employees present in a particular site
    }

    public function findCAttendances($category, $site, $from, $to)
    {

      if($site == 0)
      {
          $att = Employee::with(['attendance'=> function($b)
          {
              return $b->whereDate('day', '>=', Carbon::now()->format('Y-m-d'))
                        ->whereDate('day', '<=', Carbon::now()->format('Y-m-d'))
                      ->where('time_in' , '!=' , null);
          }])->where('category_id', 2)->get();

          $actual = $att->reject(function($attendance){
              return !count($attendance->attendance);
          });
          return $actual;
      }else
      {

        $att = Employee::with(['attendance'=> function($b)
        {
            return $b->whereDate('day', '>=', Carbon::parse($_POST['from'])->format('Y-m-d'))
                    ->whereDate('day', '<=', Carbon::parse($_POST['to'])->format('Y-m-d'))
                    ->where('time_in' , '!=' , null)
                    ->where('site_id' , $_POST['site_show']);
        }])->where('category_id', 2)->get();

        $actual = $att->reject(function($attendance){
            return !count($attendance->attendance);
        });

        return $actual;

      }

    }

    public function findAttendances($category, $site)
    {
      if($site == 0)
      {
          $att = Employee::with(['attendance'=> function($b)
          {
              return $b->whereDate('day', '>=', Carbon::now()->format('Y-m-d'))
                        ->whereDate('day', '<=', Carbon::now()->format('Y-m-d'))
                      ->where('time_in' , '!=' , null);
          }])->where('category_id', 1)->get();

          $actual = $att->reject(function($attendance){
              return !count($attendance->attendance);
          });
          return $actual;
      }else
      {

        $att = Employee::with(['attendance'=> function($b)
        {
            return $b->whereDate('day', '>=', Carbon::parse($_POST['from'])->format('Y-m-d'))
                    ->whereDate('day', '<=', Carbon::parse($_POST['to'])->format('Y-m-d'))
                    ->where('time_in' , '!=' , null)
                    ->where('site_id' , $_POST['site_show']);
        }])->where('category_id', 1)->get();

        $actual = $att->reject(function($attendance){
            return !count($attendance->attendance);
        });

        return $actual;

      }


    }
    public function findcasualCheckoutAttendances($category, $site)
    {
      if($site == 0)
      {
        $att = Employee::with(['attendance'=> function($b)
        {
            return $b->whereDate('day', Carbon::now()->format('Y-m-d'))
                    ->where('time_in' , '!=' , null)
                    ->where('time_out', '!=', null );
                  }])->where('category_id', 2)->get();

        $actual = $att->reject(function($attendance){
            return !count($attendance->attendance);
        });
        return $actual;

      }else{
        $att = Employee::with(['attendance'=> function($b)
        {
            return $b->whereDate('day', Carbon::now()->format('Y-m-d'))
                    ->where('time_in' , '!=' , null)
                    ->where('time_out', '!=', null )
                    ->where('site_id', $_POST['site_show']);
    }])->where('category_id', 2)->get();

        $actual = $att->reject(function($attendance){
            return !count($attendance->attendance);
        });
        return $actual;


      }

    }
     public function findstaffCheckoutAttendances($category, $site)
    {
      if($site == 0)
      {
        $att = Employee::with(['attendance'=> function($b)
        {
            return $b->whereDate('day', Carbon::now()->format('Y-m-d'))
                    ->where('time_in' , '!=' , null)
                    ->where('time_out', '!=', null );
    }])->where('category_id', 1)->get();

        $actual = $att->reject(function($attendance){
            return !count($attendance->attendance);
        });
        return $actual;
      }else{
        $att = Employee::with(['attendance'=> function($b)
        {
            return $b->whereDate('day', Carbon::now()->format('Y-m-d'))
                    ->where('time_in' , '!=' , null)
                    ->where('time_out', '!=', null )
                    ->where('site_id', $_POST['site_show']);
    }])->where('category_id', 1)->get();

        $actual = $att->reject(function($attendance){
            return !count($attendance->attendance);
        });
        return $actual;
      }


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
}
