<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    


     public function monthdays(){

    	return $this->hasOne('App\CalendarDay');
    }
}
