<?php

use App\Models\Event;
use App\Models\Driver;
use App\Models\Penalty;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Driver::class, 'accused_id');
            $table->foreignIdFor(Driver::class, 'victim_id');
            $table->foreignIdFor(User::class, 'reported_by_id');
            $table->foreignIdFor(Penalty::class, 'penalty_id');
            $table->foreignIdFor(Event::class, 'event_id');
            $table->string('timestamp');
            $table->text('description');
            $table->text('reviewers_notes');
            $table->string('status');
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
        Schema::dropIfExists('incidents');
    }
}
