<?php

use App\Setting;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keys = [
            'overtime', 'standard_rate', 'special_rate', 'standard_type', 'special_type', 'leave_accrual',
            'leave', 'leave_min_working_days', 'multiple_checkins', 'rate_per_hour', 'undertime', 'leave_rate'
        ];

        foreach ($keys as $key) {
            DB::table('settings')->insert([
                'setting_key' => $key,
                'setting_value' => $this->setDefaults($key),
                'default_value' => $this->setDefaults($key),
                'description' => 'description',
                'title' => $this->setTitle($key),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        DB::table('settings')->insert([
            'setting_key' => Setting::PAYROLL_PREFIX,
            'setting_value' => 'WIZ-',
            'default_value' => 'WIZ-',
            'description' => 'The Prefix to be used on the Payroll number.',
            'title' => 'Payroll Number Prefix',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

    }

    public function setDefaults($value) {
        switch ($value) {
            case 'overtime':
                return 'Enabled';
            case 'standard_rate':
                return '1.5';
            case 'standard_type':
                return 'rate';
            case 'special_rate':
                return '2';
            case 'special_type':
                return 'rate';
            case 'leave':
                return 'enabled';
            case 'leave_min_working_days':
                return '26';
            case 'multiple_checkins':
                return 'disabled';
            case 'rate_per_hour':
                return '400';
            case 'leave_accrual':
                return 'disabled';
            case 'undertime':
                return 'disabled';
            case 'leave_rate':
                return '1.5';
            default:
                return '';
        }
    }

    public function setTitle($value) {
        switch ($value) {
            case 'overtime':
                return 'Overtime';
            case 'standard_rate':
                return 'Standard day rate';
            case 'standard_type':
                return 'Standard day type';
            case 'special_rate':
                return 'Special day rate';
            case 'special_type':
                return 'Special day type';
            case 'leave':
                return 'Leave';
            case 'leave_min_working_days':
                return 'Minimum working days to be entitled to leave';
            case 'multiple_checkins':
                return 'Multiple check-ins';
            case 'rate_per_hour':
                return 'Rate per hour';
            case 'undertime':
                return 'Undertime';
            case 'leave_accrual':
                return "Leave accrual";
            case 'leave_rate':
                return 'Rate of leave';
            default:
                return '';
        }
    }
}
