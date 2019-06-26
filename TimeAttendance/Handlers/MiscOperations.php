<?php

namespace Handlers;

use App\Employee;
use App\Holiday;
use App\Leave;
use App\Overtime;
use App\OvertimeSlab;
use App\Rate;
use Carbon\Carbon;
use App\Setting;

class MiscOperations
{

    public static function fetchSettings($fields) {

        return Setting::all()
            ->reject(function($value) use ($fields) {
                return !in_array($value->setting_key, $fields);
            })
            ->keyBy('setting_key')
            ->map(function($value) {
                return $value->setting_value == "" ? $value->default_value : $value->setting_value;
            })
            ->toArray();
    }

    public static function calculateOvertimeRedefined($id) {
        if(Overtime::where('day', Carbon::yesterday())->where('employee_id', $id)->get()->count() > 0) {
            return;
        }
        $attendance = Employee::with(['attendance' => function ($query) {
            $query->select(['employee_id', 'time_in', 'time_out', 'day'])
                ->where('day', Carbon::yesterday())
                ->orderBy('time_out', 'asc');
        }])->where('id', $id)->get();
        $shifts = Employee::with(['shifts' => function($query) {
            $query->orderBy('shift_end', 'asc');
        }])->where('id', $id)->get()->first();

        $needed = [
            'standard_type', 'special_type', 'standard_rate', 'special_rate', 'rate_per_hour'
        ];
        $settings = Overtime::all();
        $slabs = OvertimeSlab::all();
        $holidays = Holiday::get()->keyBy('name')->map(function($value) {
            return $value->day."-".$value->month;
        })->toArray();
        $amount = 0;
        $overtime_hours = 0;
        $hours = 0;

        if(!strpos($shifts->day, Carbon::yesterday()->format('l')) || in_array(Carbon::yesterday()->format('d-m'), $holidays)) {
            $attendance->each(function ($att) use ($hours) {
                if(isset($att->first()->attendance->first()->time_out) &&
                    Carbon::parse($att->first()->attendance->first()->time_in)
                        ->diffInHours(Carbon::parse($att->first()->attendance->first()->time_in)) >= 1) {
                    $hours += Carbon::parse($att->first()->attendance->first()->time_in)
                        ->diffInHours(Carbon::parse($att->first()->attendance->first()->time_in));
                }
            });
            if($hours == 0) {
                return;
            }

            $overtime_hours = $hours;
            if($settings['special_type'] = 'slab') {
                $slabs = $slabs->reject(function($value) {
                    return $value->type == 'standard';
                })->sortBy('maximum')->each(function($value) use ($hours, $amount, $settings) {
                    if($hours > $value->maximum) {
                        $amount += $value->maximum * $value->rate * intval($settings['rate_per_hour']);
                        $hours -= $value->maximum;
                    } else {
                        $amount += $hours * $value->rate * intval($settings['rate_per_hour']);
                        return false;
                    }
                });
                Employee::where('id', $id)->first()->overtime()->create([
                    'time_taken' => $overtime_hours, 'day' => Carbon::yesterday(), 'amount' => $amount, 'type' => 'special'
                ]);
            } else {
                Employee::where('id', $id)->first()->overtime()->create([
                    'time_taken' => $overtime_hours, 'day' => Carbon::yesterday(),
                    'amount' => $overtime_hours * floatval($settings['special_rate']) * intval($settings['rate_per_hour']),
                    'type' => 'special'
                ]);
            }
        } else {
            $shifts->each(function($shift) use ($attendance, $hours) {
                $attendance->each(function ($att) use ($shift, $hours) {
                    if(!isset($att->first()->attendance->first()->time_out)) {
                        return false;
                    }
                    if(Carbon::parse($att->first()->attendance->first()->time_out)->get(Carbon::parse($shift->shift_end)) &&
                        Carbon::parse($att->first()->attendance->first()->time_out)->diffInHours(Carbon::parse($shift->shift_end)) >= 1) {
                        $hours += Carbon::parse($att->first()->attendance->first()->time_out)->diffInHours(Carbon::parse($shift->shift_end));
                    }
                });
            });
            if($hours == 0) {
                return;
            }

            $overtime_hours = $hours;
            if($settings['standard_type'] = 'slab') {
                $slabs = $slabs->reject(function($value) {
                    return $value->type == 'special';
                })->sortBy('maximum')->each(function($value) use ($hours, $amount, $settings) {
                    if($hours > $value->maximum) {
                        $amount += $value->maximum * $value->rate * intval($settings['rate_per_hour']);
                        $hours -= $value->maximum;
                    } else {
                        $amount += $hours * $value->rate * intval($settings['rate_per_hour']);
                        return false;
                    }
                });
                Employee::where('id', $id)->first()->overtime()->create([
                    'time_taken' => $overtime_hours, 'day' => Carbon::yesterday(), 'amount' => $amount, 'type' => 'special'
                ]);
            } else {
                Employee::where('id', $id)->first()->overtime()->create([
                    'time_taken' => $overtime_hours, 'day' => Carbon::yesterday(),
                    'amount' => $overtime_hours * $settings['standard_rate'] * intval($settings['rate_per_hour']),
                    'type' => 'standard'
                ]);
            }
        }
    }
}