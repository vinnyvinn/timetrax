<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [ 'name', 'day', 'shift_start', 'shift_end', 'break'];

    public function employee()
    {
        return $this->belongsToMany(Employee::class, 'employee_shifts');

    }
}
