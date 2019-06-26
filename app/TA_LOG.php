<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TA_LOG extends Model
{

    const DONE = 1;

    const CHECKIN = 'CHECKIN';
    const CHECKOUT = 'CHECKOUT';

    protected $fillable=['status'];
    protected $connection ='sqlsrv_ta_log';

    protected $table ='TIK_TALogs';

}
