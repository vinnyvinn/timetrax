<?php

namespace App\importRepo;
use Illuminate\Support\Facades\DB;
use App\LeaveType;
/**
* imports leaves from HR 
*/
class Leaves
{
	
	public function handle()
	{
			$data=DB::connection('sqlsrv')->select('SELECT * FROM  tblLeave');
			$results=$this->uniqueData($data);
			if($this->createLeaveCategory($results)){
				return true;
			}else{
				return false544;
			}
	}

	public  function  uniqueData($data){
		$uniData=array();
		foreach ($data as $value) {
				$uni=LeaveType::where('leave_code', $value->Leave_Code)->first();
				if(count($uni)==0){
					array_push($uniData, $value);
				}
		}
		return $uniData;
	}

	public function createLeaveCategory($data){
		foreach ($data as $leave) {
			$name=$leave->Leave_Name;
			LeaveType::create([
					'leave_id'=> $leave->Leave_Id,
					'leave_code'=>$leave->Leave_Code,
					'leave_name'=>$name,
					'leave_alias'=>strtoupper($name[0])
				]);
		}
		return true;
	}
}