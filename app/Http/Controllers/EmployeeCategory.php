<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\HREmployee;
use App\importRepo\Disgnations;
class EmployeeCategory extends Controller
{
    
    public function index(){

    	return view('employee.category.index');
    }

    public function show($id){
    			$data=Employee::where('user_id',$id)->get();
    	return view('employee.category.show',['data'=>$data]);
    }

    public function importHr(){

    	$import=new Disgnations();
    	if($import->importDesignation()){
		  return response()->json('success');
		}else{

		  return response()->json('error');
		}

    	
    }
}
