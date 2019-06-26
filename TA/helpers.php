<?php
use App\Role;
use App\Setting;

/**
 * Created by PhpStorm.
 * User: koi
 * Date: 10/11/16
 * Time: 11:14 AM
 */

function hasPermission($permission)
{
    if (Auth::guest()) {
        return false;
    }

    if (Auth::user()->role_id == 0) {
        return true;
    }

    $roleId = Auth::user()->role_id;

    if ($roleId == 0) {
        return true;
    }

    $rolePermissions = json_decode(getRole($roleId)->permissions);

    return in_array($permission, $rolePermissions);
}

function getRole($roleId) {
    if (! Cache::has(Role::CACHE_KEY)) {
        recacheRoles();
    }

    return Cache::get(Role::CACHE_KEY)
        ->where('id', $roleId)
        ->first();
}

function recacheRoles() {
    Cache::forget(Role::CACHE_KEY);
    Cache::rememberForever(Role::CACHE_KEY, function () {
        return Role::all(['name', 'id', 'permissions']);
    });
}

function flash($message, $status = 'success')
{
    Session::flash('flash_message', $message);
    Session::flash('flash_message_status', $status);
}

function getPayrollNumberPrefix() {
    return getSetting(Setting::PAYROLL_PREFIX);
}

function getSetting($settingName) {
    if (! Cache::has(Setting::CACHE_KEY)) {
        cacheSettings();
    }

    $setting = Cache::get(Setting::CACHE_KEY)->where('setting_key', $settingName)->first();

    if (! $setting) {
        return '';
    }

    return $setting->setting_value;
}

function cacheSettings() {
    Cache::forget(Setting::CACHE_KEY);
    Cache::rememberForever(Setting::CACHE_KEY, function () {
        return Setting::all();
    });
}