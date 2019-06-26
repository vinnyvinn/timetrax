<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeOvertime extends Model
{
    protected $fillable = [
        'employee_id', 'overtime_id', 'day', 'hours'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function overtime()
    {
        return $this->belongsTo(Overtime::class);
    }
}
