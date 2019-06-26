<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Role;
use App\User;

class HREmployee extends Model
{
    
    protected $connection="sqlsrv"; //tblDesignation

    protected $table="tblEmployee";

    public function handle(){
    	 $dbData=DB::connection('sqlsrv')->select("SELECT * FROM tblEmployee INNER JOIN tblEmployee_Contact ON tblEmployee_Contact.Emp_Id=tblEmployee.Emp_Id");
    		$results=$this->getUnique($dbData);

         //   echo json_encode($results);
    	 if($this->insert($results)){
			    	 	return true;
			    	 }else{
			    	 	return false;
			    	 }

    }

    public function insert($results){
    		 foreach ($results as $result){
            $user = new User();
            $user->email=$result->Emp_WorkEmail;
            $user->password=bcrypt('Qwerty!1234');
            $user->name=$result->Emp_Name;
            $user->role_id=1;
            $user->save();
            $lastID=$user->id;
            
            $newEmployee=new Employee();
            $newEmployee->user_id=$lastID;
            $newEmployee->company_id=1;
            $newEmployee->category_id=$result->Category_Id;
            $newEmployee->payroll_number=$result->Emp_Payroll_No;
            $newEmployee->first_name=$result->Emp_First_Name;
            $newEmployee->last_name=$result->Emp_Middle_Name." ".$result->Emp_Last_Name;
            $newEmployee->save();
        }
        return true;
    		}

    public function getUnique($employees){

		$unique=array();
		foreach ($employees as $key => $employee) {
					$data=User::where('email',$employee->Emp_WorkEmail)->first();
					if(count($data)==0){
								array_push($unique,$employee);
					}
		}

    	return $unique;
    }


}
