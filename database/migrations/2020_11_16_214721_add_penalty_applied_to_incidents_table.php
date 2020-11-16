<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPenaltyAppliedToIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->boolean('penalty_applied')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn('penalty_applied');
        });
    }
}
