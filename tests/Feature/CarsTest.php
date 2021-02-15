<?php

namespace Tests\Feature;

use App\Importers\AcCarsFromSgpConverter;
use App\Importers\AccCarsFromSgpConverter;
use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_acc_formatted_data()
    {
        Car::truncate();
        $cars = (new AccCarsFromSgpConverter())->getFormatted();


        Car::insert($cars);


        $this->assertDatabaseCount('cars', count($cars));
        $firstRecord = Car::first();
        $firstImport = $cars[0];

        $this->assertEquals($firstRecord->id, $firstImport['id']);
        $this->assertEquals($firstRecord->name, $firstImport['name']);
        $this->assertEquals($firstRecord->type, $firstImport['type']);
        $this->assertEquals('acc', $firstRecord->sim);
    }

    /** @test */
    public function it_imports_ac_formatted_data()
    {
        Car::truncate();
        $cars = (new AcCarsFromSgpConverter())->getFormatted();


        Car::insert($cars);


        $this->assertDatabaseCount('cars', count($cars));

        $firstImport = $cars[0];
        $record = Car::firstWhere('id', $firstImport['id']);

        $this->assertEquals($record->name, $firstImport['name']);
        $this->assertEquals('ac', $record->sim);
        $this->assertNull($record->type);
    }

    /** @test */
    public function it_runs_from_a_command()
    {
        $this->artisan('sgp:rebuild-acc-cars')
             ->expectsOutput('Cars Imported.');


        $count = count((new AccCarsFromSgpConverter())->getFormatted());
        $count += count((new AcCarsFromSgpConverter())->getFormatted());
        $this->assertDatabaseCount('cars', $count);
    }

}
