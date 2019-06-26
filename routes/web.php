<?php

use Illuminate\Http\Request;
use App\Attendance;
use App\AttendanceLog;
use TA\Managers\AttendanceManager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index');
    Route::post('dashboard-filter', 'DashboardController@records');
    Route::resource('leave', 'LeaveController');
    Route::get('employee/attendance', 'EmployeeController@attendance');
    Route::post('employee/attendance', ['as' => 'attendance.checkInOrOut', 'uses' =>'EmployeeController@storeAttendance']);

    Route::get('emp/category','EmployeeCategory@index');
    Route::get('/modifyCatgory/{id}/','EmployeeCategory@show')->name('modifyCatgory');
    Route::get('employee/import',[
        'as'=>'import',
        'uses'=>'EmployeeController@import'
        ]);
    Route::post('employee/importCSV',[
        'as'=>'employee/importCSV',
        'uses'=>'EmployeeController@importCSV'
        ]);
     Route::get('employee/hr',[
        'as'=>'employee/hr',
        'uses'=>'EmployeeController@importHR'
        ]);
    Route::resource('newreports','CombineReportsController');
    Route::get('designation/hr','EmployeeCategory@importHr');
    Route::resource('calendar','WorkingDays');
    //
    Route::resource('employee', 'EmployeeController');
    Route::resource('user', 'UsersController');
    Route::resource('holiday', 'HolidayController');
    Route::resource('attendance', 'AttendanceController');
    Route::resource('overtime', 'OvertimeController');
    Route::resource('shift', 'ShiftController');
    Route::resource('overtime', 'OvertimeController');
    Route::resource('company', 'CompanyController');
    Route::resource('sites', 'SiteController');

//    Route::post('overtime-data', 'OvertimeController@retrieveOvertimes');

    Route::resource('role', 'RoleController');
    Route::get('resync', 'DashboardController@resync');
    Route::get('change-password', 'PasswordController@index')->name('change-password.index');
    Route::post('change-password', 'PasswordController@store')->name('change-password.store');

    Route::group(['as' => 'reports.'], function () {
        Route::resource('reports/attendance', 'AttendanceReportController');
        Route::resource('reports/employee','EmployeeReportController');
        Route::resource('reports/leave' , 'LeaveReportController');
        Route::resource('reports/overtime', 'OvertimeReportController');
        Route::resource('reports/attendance', 'AttendanceReportController');
        Route::resource('reports/exception', 'ExceptionReportController');

//        Route::resource('reports/attendanceSummary', 'AttendanceSummaryReportController');
        Route::resource('reports/shift', 'ShiftReportController');
    });
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'SettingController@retrieveConfigs');
        Route::get('leave-importHR', 'SettingController@leaveHR');
        Route::get('leave-settings', 'SettingController@leavImport');
        Route::get('leave-import', 'SettingController@leavePage');
        Route::get('overtime-settings', 'SettingController@overtimePage');
        Route::get('prefix-settings', 'SettingController@changePrefix');
        Route::post('prefix-update', 'SettingController@updatePrefix');
        Route::get('misc-settings', 'SettingController@miscPage');
        Route::group(['prefix' => 'overtime'], function() {
            Route::get('/', 'SettingController@overtime');
            Route::post('update', 'SettingController@saveOvertime');
            Route::get('standard-type', 'SettingController@overtimeStandardType');
            Route::post('standard-type/update', 'SettingController@saveOvertimeStandardType');
            Route::get('special-type', 'SettingController@overtimeSpecialType');
            Route::post('special-type/update', 'SettingController@saveOvertimeSpecialType');
            Route::get('standard-rate', 'SettingController@overtimeStandardRate');
            Route::post('standard-rate/update', 'SettingController@saveOvertimeStandardRate');
            Route::get('special-rate', 'SettingController@overtimeSpecialRate');
            Route::post('special-rate/update', 'SettingController@saveOvertimeSpecialRate');
            Route::get('standard-slabs', 'SettingController@overtimeStandardSlab');
            Route::post('standard-slabs/update', 'SettingController@saveOvertimeStandardSlab');
            Route::get('special-slabs', 'SettingController@overtimeSpecialSlab');
            Route::post('special-slabs/update', 'SettingController@saveOvertimeSpecialSlab');
        });
        Route::group(['prefix' => 'leave'], function () {
            Route::get('/', 'SettingController@leave');
            Route::post('update', 'SettingController@saveLeave');
            Route::get('min-days', 'SettingController@leaveMinimumDays');
            Route::post('min-days/update', 'SettingController@saveLeaveMinimumDays');
            Route::get('accrual', 'SettingController@leaveAccrual');
            Route::post('accrual/update', 'SettingController@saveLeaveAccrual');
            Route::get('rate', 'SettingController@leaveRate');
            Route::post('rate/update', 'SettingController@saveLeaveRate');
        });
        Route::group(['prefix' => 'misc'], function() {
            Route::get('multiple-checkins', 'SettingController@multipleCheckins');
            Route::post('multiple-checkins/update', 'SettingController@saveMultipleCheckins');
            Route::get('undertime', 'SettingController@undertime');
            Route::post('undertime/update', 'SettingController@saveUndertime');
            Route::get('checkinbutton', 'SettingController@checkinbutton');
            Route::post('checkinbutton/update', 'SettingController@savecheckinbutton');
        });
    });
});


Route::get('/faker', function() {
    $users = factory(\App\User::class, 20)->make();

    $users->each(function($user) {
        $user->save();
        $user->employee = factory(\App\Employee::class)->make();
        $user->employee()->create($user->employee->toArray());
    });
});

//api routes

Route::group(['prefix' => 'api/v1'], function() {
    Route::group([], function () {
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


// });

// Route::group(['middleware'=>'auth:api'],function() {

    Route::resource('payroll','ApiController\PayRollController');
    Route::resource('users','ApiController\UserController');
    Route::get('companies','ApiController\UserController@companies');
    Route::resource('sitesapi','ApiController\LocationController');
    Route::get('check_employee/{id_num}','ApiController\UserController@employee_exists');
    Route::post('register_employee', 'ApiController\UserController@register_employee');
    Route::post('user_sites', 'ApiController\UserController@user_sites');
    Route::post('record_leave', 'ApiController\UserController@record_leave');
    Route::post('store_leave', 'ApiController\UserController@store_leave');

    Route::post('checkin_employee', 'ApiController\UserController@employee_checkin');
    Route::post('checkout_employee', 'ApiController\UserController@checkout_employee');
    Route::post('get_distance', 'ApiController\LocationController@get_distance');
    Route::post('authenticate', 'ApiController\UserController@authenticate');
});
});
