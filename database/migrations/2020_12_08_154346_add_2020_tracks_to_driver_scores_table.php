<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add2020TracksToDriverScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_scores', function (Blueprint $table) {
            $table->mediumInteger("barcelona_2020")->default(0);
            $table->mediumInteger("brands_hatch_2020")->default(0);
            $table->mediumInteger("hungaroring_2020")->default(0);
            $table->mediumInteger("misano_2020")->default(0);
            $table->mediumInteger("monza_2020")->default(0);
            $table->mediumInteger("nurburgring_2020")->default(0);
            $table->mediumInteger("paul_ricard_2020")->default(0);
            $table->mediumInteger("silverstone_2020")->default(0);
            $table->mediumInteger("spa_2020")->default(0);
            $table->mediumInteger("zandvoort_2020")->default(0);
            $table->mediumInteger("zolder_2020")->default(0);
            $table->mediumInteger("imola_2020")->default(0);
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
            $table->dropColumn("barcelona_2020");
            $table->dropColumn("brands_hatch_2020");
            $table->dropColumn("hungaroring_2020");
            $table->dropColumn("misano_2020");
            $table->dropColumn("monza_2020");
            $table->dropColumn("nurburgring_2020");
            $table->dropColumn("paul_ricard_2020");
            $table->dropColumn("silverstone_2020");
            $table->dropColumn("spa_2020");
            $table->dropColumn("zandvoort_2020");
            $table->dropColumn("zolder_2020");
            $table->dropColumn("imola_2020");
        });
    }
}
