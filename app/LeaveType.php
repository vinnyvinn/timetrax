<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    
    protected $table="leave_types";
    protected $fillable=['leave_id','leave_name','leave_code','leave_alias'];


	public function leave(){
		return $this->belongsTo('App\Leave', 'leave_id', 'leave_category');
	}
}
