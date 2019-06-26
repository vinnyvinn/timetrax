<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    const CACHE_STANDARD = 'standard_OT',
        CACHE_SPECIAL = 'special_OT',
        STANDARD_OT = 'Standard Overtime',
        SPECIAL_OT = 'Special Overtime';

    protected $fillable = [
        'name','type', 'rate', 'description'
    ];

    public function slabs()
    {
        return $this->hasMany(OvertimeSlab::class);
    }

    public static function standard()
    {
        if (! Cache::has(self::CACHE_STANDARD)) {
            Cache::remember(self::CACHE_STANDARD, 3600, function () {
                return self::where('name', self::STANDARD_OT)->first();
            });
        }

        return Cache::get(self::CACHE_STANDARD);
    }

    public static function special()
    {
        if (! Cache::has(self::CACHE_SPECIAL)) {
            Cache::remember(self::CACHE_SPECIAL, 3600, function () {
                return self::where('name', self::SPECIAL_OT)->first();
            });
        }

        return Cache::get(self::CACHE_SPECIAL);
    }
}
