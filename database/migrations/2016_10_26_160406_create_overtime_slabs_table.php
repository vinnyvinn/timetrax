<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimeSlabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_slabs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('overtime_id')->unsigned()->index();
            $table->float('beginning');
            $table->float('ending')->nullable();
            $table->float('rate');
            $table->timestamps();

            $table->foreign('overtime_id')
                ->references('id')
                ->on('overtimes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overtime_slabs');
    }
}
