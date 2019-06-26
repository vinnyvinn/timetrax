<?php

use Illuminate\Database\Seeder;
use App\Month;
class MonthsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array=array("January","February","March","April","May","June","July","August","September","October","November","December");

        for($i=0;$i<count($array); $i++){
        			Month::create([
        				'month'=>$array[$i]
        			]);
        }
    }
}
