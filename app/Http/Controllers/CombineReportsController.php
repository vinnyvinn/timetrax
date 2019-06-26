<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Month;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Employee;
use App\Attendance;
use App\Leave;
class CombineReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $months=Month::get();
        return  view('reports.newReport.index',['months'=>$months]);
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
        Excel::create('newreport',function($excel) use($request){
            if($request->employee_id=="all"){
                 $month = $request->calendar_year.'-'.$request->month;
                 $excel->sheet("Guids",function(){
                    
                 });
                 $excel->sheet($month, function($sheet) use ($request){
                    $month = $request->calendar_year.'-'.$request->month;
                    $start = Carbon::parse($month)->startOfMonth();
                    $end = Carbon::parse($month)->endOfMonth();
                    $dates[]='Dates';
                    $names[]="Employee Names";
                     while ($start->lte($end)) {
                             $dates[] = $start->format('d');
                             $names[] = date('D',strtotime($start));
                             $start->addDay();
                         }
                    $employedata=array();
                    $emps=Employee::get();
                        foreach($emps as $emp){
                            $empdata=[];
                            $empdata[]=$emp->first_name." ".$emp->last_name;
                            $data=$this->getThisEmployeeData($emp->id,$month);
                            $empdata[]=$data;
                            array_push($employedata ,array_flatten($empdata));
                        }
                    $sheet->row(3,$dates);
                    $sheet->row(4,$names);
                    $sheet->row(3, function($row) {
                     $row->setBackground('#e8ea9c');
                     $row->setAlignment('center');
                    });
                    $sheet->row(4, function($row) {
                     $row->setBackground('#7be77b');
                     $row->setAlignment('center');
                    });

                    for($i=5,$k=0; $i<=count($employedata) ,$k< count($employedata); $i++,$k++){
                        $sheet->row($i,$employedata[$k]);
                    }
                 });
            }
           
        })->export($request->format);


    // dd($request);
// employee_id
// month
// calendar_year
// format
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


    public function getThisEmployeeData($id,$month)
    {
        $attendance=[];
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        while ( $start->lte($end) ) {
      
                $inattedance=Attendance::where('employee_id',$id)->where('day',$start->toDateString())->first();
                if(count($inattedance)==0){
                    $onleave=Leave::where('employee_id',$id)
                             ->whereDate('start_date','<=',$start)
                             ->whereDate('end_date','>=',$end)
                             ->with('leaveType')->first();
                    if(count($onleave)==0){
                        $attendance[]=0;
                    }else{
                        $attendance[]=$onleave->leaveType->first()->leave_alias;
                    }
                }else{
                    $attendance[]=1;
                }
               
                    $start->addDay();
                 }
        return $attendance;
    }
}
