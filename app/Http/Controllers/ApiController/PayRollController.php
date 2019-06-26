<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Attendance;
use App\Employee;
use App\Leave;

class PayRollController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data="success";
        return response()->json($data);
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
     * @param  \Illuminate\Http\Request  $request,payroll_no,month,year
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //perfomTast
        $data=array();
          $details=Employee::where('payroll_number',$request->payroll_no)->first();
            if(count($details)==0){
                array_push($data,['error'=>"employee with that payroll number doesnt exist",202]);
            }else{

                array_push($data, ['name' => $details->first_name." ".$details->last_name,'payroll_no'=>$details->payroll_number]);

                $months=explode(',', $request->month);

                for($i=0; $i<count($months); $i++){
                    $name= date("F",mktime(0,0,0,$months[$i],1));
                    array_push($data, ["month"=>$name,'data'=>self::auditAttedance($months[$i],$request,$details->id) ]);
                 }
            }

            

        return response()->json($data);

    }

    public static function auditAttedance($month,$request,$id){
            $data=[];
            $attendances=Attendance::where('employee_id',$id)->whereMonth('created_at',$month)->whereYear('created_at',$request->year)->get();
            $data['days']=count($attendances);
            $data['hrs']=48;
            $leaves=Leave::where('employee_id',$id)
                    ->whereMonth('created_at',$month)->whereYear('created_at',$request->year)
                    ->select( DB::raw('SUM(days) as days'))
                    ->havingRaw('SUM(days) > 0')->get();
                if(count($leaves)>0){
                      $data['leaves']=$leaves->first()->days;

                }else{
                      $data['leaves']=0;
                }

            return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        dd($id);
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
