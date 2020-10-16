<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->nullable();
            $table->foreignId('event_id');
            $table->tinyInteger('position');
            $table->smallInteger('laps');
            $table->smallInteger('clean_laps');
            $table->bigInteger('quali_time');
            $table->bigInteger('total_time');
            $table->bigInteger('best_lap');
            $table->smallInteger('race_number')->default(1);
            $table->smallInteger('penalty_points')->nullable();
            $table->smallInteger('best_lap_points')->nullable();
            $table->smallInteger('top_quali_points')->nullable();
            $table->smallInteger('points')->nullable();
            $table->smallInteger('final_points')->nullable();
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_entries');
    }
}
