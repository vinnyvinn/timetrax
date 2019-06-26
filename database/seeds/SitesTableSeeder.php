<?php

use Illuminate\Database\Seeder;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         DB::table('sites')->insert([
            'name' => 'Head Office',
            'description' => 'Main office',
            'lt' => -1.3369715,
            'ld' => 36.8803792,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
