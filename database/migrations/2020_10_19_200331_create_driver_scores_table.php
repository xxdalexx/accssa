<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('driver_id');
            $table->mediumInteger("barcelona")->default(0);
            $table->mediumInteger("brands_hatch")->default(0);
            $table->mediumInteger("barcelona_2019")->default(0);
            $table->mediumInteger("brands_hatch_2019")->default(0);
            $table->mediumInteger("hungaroring")->default(0);
            $table->mediumInteger("hungaroring_2019")->default(0);
            $table->mediumInteger("kyalami_2019")->default(0);
            $table->mediumInteger("laguna_seca_2019")->default(0);
            $table->mediumInteger("misano")->default(0);
            $table->mediumInteger("misano_2019")->default(0);
            $table->mediumInteger("monza")->default(0);
            $table->mediumInteger("monza_2019")->default(0);
            $table->mediumInteger("mount_panorama_2019")->default(0);
            $table->mediumInteger("nurburgring")->default(0);
            $table->mediumInteger("nurburgring_2019")->default(0);
            $table->mediumInteger("paul_ricard")->default(0);
            $table->mediumInteger("paul_ricard_2019")->default(0);
            $table->mediumInteger("silverstone")->default(0);
            $table->mediumInteger("silverstone_2019")->default(0);
            $table->mediumInteger("spa")->default(0);
            $table->mediumInteger("spa_2019")->default(0);
            $table->mediumInteger("suzuka_2019")->default(0);
            $table->mediumInteger("zandvoort")->default(0);
            $table->mediumInteger("zandvoort_2019")->default(0);
            $table->mediumInteger("zolder")->default(0);
            $table->mediumInteger("zolder_2019")->default(0);

            $table->timestamps();

            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_scores');
    }
}
