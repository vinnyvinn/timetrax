<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    const PERM = 1;
    const CASUAL = 2;
    const INTERN = 3;
    //
    protected $fillable =[
        'first_name',
        'last_name',
        'payroll_number',
        'user_id',
        'wage',
        'category_id',
        'company_id',
        'id_number'
    ];

    public function permission()
    {
        return $this;
    }
    public function leave()
    {
        return $this->hasMany(Leave::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function overtime()
    {
        return $this->hasMany(EmployeeOvertime::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'employee_shifts');
    }

    public function sites()
    {
        return $this->hasOne(EmployeeSite::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }
}
