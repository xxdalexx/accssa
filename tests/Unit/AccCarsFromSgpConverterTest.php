<?php

namespace Tests\Unit;

use App\Importers\AccCarsFromSgpConverter;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class AccCarsFromSgpConverterTest extends TestCase
{
    /** @test */
    public function it_constructs_with_cars_collection()
    {
        $converter = new AccCarsFromSgpConverter();
        $this->assertInstanceOf(Collection::class, $converter->getCars());
        $this->assertGreaterThan(0, $converter->getCars()->count());
    }

    /** @test */
    public function it_()
    {
        $converter = (new AccCarsFromSgpConverter());
    }
}
