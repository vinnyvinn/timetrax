<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const PERM_ATTENDANCE_VIEW_ALL = 0;
    const PERM_ATTENDANCE_VIEW_INDIVIDUAL = 1;
    const PERM_EMPLOYEE_VIEW_ALL= 2;
    const PERM_EMPLOYEE_ADD = 3;
    const PERM_EMPLOYEE_EDIT = 4;
    const PERM_EMPLOYEE_DELETE = 5;
    const PERM_LEAVE_VIEW_ALL = 6;
    const PERM_LEAVE_VIEW_INDIVIDUAL = 7;
    const PERM_LEAVE_ADD= 8;
    const PERM_LEAVE_EDIT = 9;
    const PERM_LEAVE_DELETE = 10;
    const PERM_SETTINGS_VIEW = 11;
    const PERM_SETTINGS_ADD = 12;
    const PERM_SETTINGS_EDIT = 13;
    const PERM_HOLIDAY_ADD = 14;
    const PERM_HOLIDAY_DELETE  = 15;
    const PERM_ROLE_VIEW_ALL = 16;
    const PERM_ROLE_ADD = 17;
    const PERM_ROLE_EDIT = 18;
    const PERM_ROLE_DELETE = 19;
    const PERM_OVERTIME_VIEW_ALL = 20;
    const PERM_OVERTIME_VIEW_INDIVIDUAL = 21;
    const PERM_REPORT_VIEW_ALL = 22;
    const PERM_SHIFT_VIEW = 23;
    const PERM_SHIFT_CREATE = 24;
    const PERM_SHIFT_EDIT = 25;
    const PERM_SHIFT_DELETE = 26;
    const PERM_VIEW_LEAVE_SETTINGS = 27;
    const PERM_VIEW_OVERTIME_SETTINGS = 28;
    const PERM_VIEW_ATTENDANCE_BUTTON = 29;
    const PERM_COMPANY_VIEW_ALL = 30;
    const PERM_COMPANY_VIEW_INDIVIDUAL = 31;
    const PERM_COMPANY_ADD = 32;
    const PERM_COMPANY_DELETE = 33;
    const PERM_COMPANY_EDIT = 34;
    const PERM_EMPLOYEE_ATTENDANCE_VIEW = 35;
    const PERM_EMPLOYEE_ATTENDANCE_ADD = 36;
    const PERM_SITE_ADD = 37;
    const CACHE_KEY = 'ROLE_TA';

    protected static function boot()
    {
        parent::boot();

        self::updated(function () {
            recacheRoles();
        });

        self::deleted(function () {
            recacheRoles();
        });

        self::created(function () {
            recacheRoles();
        });
    }


    protected $fillable = [
        'name', 'permissions','role_status','disgnation_code'];

    public function user()
    {
        return $this->hasMany(User::class);

    }
}
