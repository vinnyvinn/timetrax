<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    protected $fillable = [
        'roll_number',
        'date_time_stamp'
    ];
}

