<?php

namespace Tests\Feature;

use App\Importers\AccCarsFromSgpConverter;
use App\Models\AccCar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccCarsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_formatted_data()
    {
        AccCar::truncate();
        AccCar::insert([
            'id' => 0,
            'name' => "Shouldn't Exist",
            'type' => 'type'
        ]);
        $cars = (new AccCarsFromSgpConverter())->getFormatted();
        AccCar::import($cars);

        $this->assertDatabaseCount('acc_cars', count($cars));
        $firstRecord = AccCar::first();
        $firstImport = $cars[0];

        $this->assertEquals($firstRecord->id, $firstImport['id']);
        $this->assertEquals($firstRecord->name, $firstImport['name']);
        $this->assertEquals($firstRecord->type, $firstImport['type']);
    }

    /** @test */
    public function it_runs_on_migration() //Will fail after migrations squashed.
    {
        $cars = (new AccCarsFromSgpConverter())->getFormatted();
        $this->assertDatabaseCount('acc_cars', count($cars));
        $firstRecord = AccCar::first();
        $firstImport = $cars[0];

        $this->assertEquals($firstRecord->id, $firstImport['id']);
        $this->assertEquals($firstRecord->name, $firstImport['name']);
        $this->assertEquals($firstRecord->type, $firstImport['type']);
    }
}
