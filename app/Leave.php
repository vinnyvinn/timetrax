<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    //
    protected $fillable = [
        'employee_id', 'start_date', 'end_date','leave_category', 'days','status'
    ];

    const STATUS = 'Pending approval';
    const APPROVED = 'Approved';
    const DECLINED = 'Declined';
    protected $dates = ['start_date', 'end_date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveType(){
        return $this->hasMany('App\LeaveType','leave_id','leave_category');
    }

}
