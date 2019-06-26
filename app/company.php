<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
   protected $fillable = [ 'name'];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
