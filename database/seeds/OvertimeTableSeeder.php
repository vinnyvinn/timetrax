<?php

use App\Overtime;
use Illuminate\Database\Seeder;

class OvertimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Overtime::create([
            'name' => Overtime::STANDARD_OT,
            'description' => 'Overtime to be used on normal working days.',
            'type' => 'Rate',
            'rate' => 1.5
        ]);

        Overtime::create([
            'name' => Overtime::SPECIAL_OT,
            'description' => 'Overtime to be used on non-working days.',
            'type' => 'Rate',
            'rate' => 2.0
        ]);
    }
}
