<?php

namespace App\importRepo;

use Illuminate\Support\Facades\DB;
use App\Role;

/**
* Import disgnations
*/
class Disgnations
{
	
	public function importDesignation()
	{
		$permissions=array(30);
		$desgnation=DB::connection('sqlsrv')->select("SELECT * FROM tblDesignation");
        $desgnations=$this->makeUniDesignantion($desgnation);
            $defaultPermission=json_encode($permissions);
            foreach ($desgnations as $value) {
                    Role::create([
                    'name' => $value->Desig_Name,
                    'disgnation_code'=>$value->Desig_Code,
                    'permissions' => $defaultPermission,
                    'role_status' => 0
                ]);
            }
            return true;
    }

    public function makeUniDesignantion($desgnations){
    		$data=array();
    		foreach ($desgnations as $value) {
    			$exists=Role::where('disgnation_code',$value->Desig_Code)->first();
    			if(count($exists)==0){
    				array_push($data, $value);
    			}
    		}
            return $data;   
    }

}