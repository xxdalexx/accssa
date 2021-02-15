<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_times', function (Blueprint $table) {
            $table->id();

            $table->string('sim');
            $table->foreignId('driver_id');
            $table->string('track_id');
            $table->string('car_id')->nullable();
            $table->string('car_type')->nullable();
            $table->mediumInteger('lap_time');
            $table->mediumInteger('per_km_time');
            $table->mediumInteger('lap_delta')->default(0);
            $table->mediumInteger('per_km_delta')->default(0);

            $table->timestamps();

            $table->unique(['sim','driver_id','track_id','car_id',]);
            $table->unique(['sim','driver_id','track_id','car_type',]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('track_times');
    }
}
