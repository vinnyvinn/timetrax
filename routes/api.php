<?php

use Illuminate\Http\Request;
use App\Attendance;
use App\AttendanceLog;
use TA\Managers\AttendanceManager;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'api'], function () {
    Route::post('attendance', function (Request $request) {
        $res = json_decode($request->data);
        $r = "";
        if (count($res->attendance) > 0) {
            $r = AttendanceManager::syncAttendance($res->attendance, $res->log);
        }

        return \Response::Json($r);
    });
    Route::get('log', function () {
        return \Response::Json(AttendanceLog::orderBy('id', 'desc')->first());
    });
    // Route::post('register_employee', 'ApiController\UserController@register_employee');
});

// Route::group(['middleware'=>'auth:api'],function() {
    
    Route::resource('payroll','ApiController\PayRollController');
    Route::resource('users','ApiController\UserController');


// });
