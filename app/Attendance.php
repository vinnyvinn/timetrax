<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id', 'time_in','time_out', 'site_id', 'day', 'overtime_id', 'clocked_minutes', 'overtime_minutes'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
