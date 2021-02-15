<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_cars', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name');
            $table->string('type');
        });

//        $cars = (new \App\Importers\AccCarsFromSgpConverter())->getFormatted();
//        \App\Models\Car::insert($cars);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_cars');
    }
}
