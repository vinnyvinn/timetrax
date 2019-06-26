<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    const CACHE_KEY = 'settings_ta_key';
    const PAYROLL_PREFIX = 'payroll_number_prefix';

    const OVERTIME_SETTING = 'overtime';
    const UNDERTIME_SETTING = 'undertime';
    const MULTIPLE_CHECKIN_SETTING = 'multiple_checkins';

    protected $fillable = [
        'setting_value'
    ];

    public static function value($setting)
    {
        if (! Cache::has(self::CACHE_KEY)) {
            Cache::rememberForever(self::CACHE_KEY, function () {
                return self::all();
            });
        }

        $setting = Cache::get(self::CACHE_KEY)->where('setting_key', $setting)->first();
        if (! $setting) {
            return false;
        }

        return $setting->setting_value;
    }
}
