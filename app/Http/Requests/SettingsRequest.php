<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'max_working_hour' => 'required|date_format:H:i',
            'working_days' => 'required|array',
            'working_hour_start' => 'required|date_format:H:i',
            'working_hour_end' => 'required|date_format:H:i',
            'lunch_hour_break' => 'required|in:enabled,disabled',
            'lunch_hour_duration' => 'required_if:lunch_hour_break,enabled|integer',
            'other_breaks' => 'required|in:enabled,disabled',
            'other_breaks_duration' => 'required_if:other_breaks,enabled|integer',
            'undertime' => 'required|in:enabled,disabled',
            'overtime' => 'required|in:enabled,disabled',
            'overtime_type' => 'required_if:overtime,enabled|in:slab,rate',
            'overtime_slab' => 'required_if:overtime_type,slab|in:accrued,direct',
            'overtime_standard_rate' => 'required_if:overtime,enabled|numeric',
            'overtime_special_rate' => 'required_if:overtime,enabled|numeric',
            'leave' => 'required|in:enabled,disabled',
            'leave_accrual' => 'required_if:leave,enabled|in:enabled,disabled',
            'leave_min_working_days' => 'required_if:leave,enabled|integer',
            'multiple_checkins' => 'required|in:enabled,disabled',
            'rate_per_hour' => 'required|integer'
        ];
    }
}
