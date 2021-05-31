<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidayHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_hours', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('day_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->foreign('day_id')->references('id')->on('holiday_days')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holiday_hours');
    }
}
