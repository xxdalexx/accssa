<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewDlcTracksToDriverScores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_scores', function (Blueprint $table) {
            $table->mediumInteger('snetterton_2019')
                ->default(0)
                ->after('imola_2020');
            $table->mediumInteger('oulton_park_2019')
                ->default(0)
                ->after('snetterton_2019');
            $table->mediumInteger('donington_2019')
                ->default(0)
                ->after('oulton_park_2019');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driver_scores', function (Blueprint $table) {
            //
        });
    }
}
