<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHumiditySensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('humidity_sensors', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 100);
            $table->text('name');
            $table->integer('alarm_threshold');
            $table->text('notes');
            $table->dateTime('measurement_start', 0)->useCurrent();
            $table->string('measurement_interval');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('humidity_sensors');
    }
}
