<?php

namespace Tests\Unit;

use App\Importers\AccTracksFromSgpConverter;
use App\Importers\AcTracksFromSgpConverter;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AcTracksFromSgpConverterTest extends TestCase
{
    /** @test */
    public function it_constructs_with_tracks_collection()
    {
        $converter = new AcTracksFromSgpConverter();
        $this->assertInstanceOf(Collection::class, $converter->getTracks());
        $this->assertGreaterThan(0, $converter->getTracks()->count());
    }

    /** @test */
    public function it_returns_formatted_data()
    {
        $formatted = (new AcTracksFromSgpConverter)->getFormatted();

        $this->assertGreaterThan(0, count($formatted));
        $this->assertGreaterThan(0, count($formatted[0]));
    }
}
