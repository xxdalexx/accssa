<?php

namespace Tests\Unit;

use App\Importers\AcCarsFromSgpConverter;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AcCarsFromSgpConverterTest extends TestCase
{
    /** @test */
    public function it_constructs_with_cars_collection()
    {
        $converter = new AcCarsFromSgpConverter();
        $this->assertInstanceOf(Collection::class, $converter->getCars());
        $this->assertGreaterThan(0, $converter->getCars()->count());
    }

    /** @test */
    public function it_returns_a_formatted_array()
    {
        $converter = new AcCarsFromSgpConverter();
        $this->assertIsArray($converter->getFormatted());
    }
}
