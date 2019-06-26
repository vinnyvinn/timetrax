<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarDay extends Model
{
    
    protected $table="calendar_days";


    protected $fillable=[
    		'month_id','days','year'
    ];



    public function month(){

    	return $this->belongsTo('App\Month');
    }
}
