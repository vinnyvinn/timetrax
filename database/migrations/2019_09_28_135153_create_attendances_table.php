<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->index()->unsigned();
            $table->integer('site_id')->index()->unsigned();
            $table->integer('overtime_id')->index()->unsigned()->nullable();
            $table->integer('clocked_minutes')->default(0);
            $table->integer('overtime_minutes')->default(0);
            $table->time('time_in');
            $table->time('time_out')->nullable();
            $table->date('day');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('overtime_id')->references('id')->on('overtimes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
