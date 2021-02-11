<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverIncidentImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_incident_import', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_id');
            $table->integer('incident_import_id');
            $table->index(['driver_id', 'incident_import_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_incident_import');
    }
}
