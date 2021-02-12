<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('track_id');
            $table->string('name');
            $table->integer('length');
            $table->integer('max_entries');
        });

        \App\Models\AccTrack::importFromSgpJson();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_tracks');
    }
}
