<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OvertimeSlab extends Model
{
    protected $fillable = [
        'overtime_id', 'beginning', 'ending', 'rate'
    ];

    public function overtime()
    {
        return $this->belongsTo(Overtime::class);
    }
}
