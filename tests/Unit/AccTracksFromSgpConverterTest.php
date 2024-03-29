<?php

namespace Tests\Unit;

use App\Importers\AccTracksFromSgpConverter;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AccTracksFromSgpConverterTest extends TestCase
{
    /** @test */
    public function it_constructs_with_tracks_collection()
    {
        $converter = new AccTracksFromSgpConverter();
        $this->assertInstanceOf(Collection::class, $converter->getTracks());
        $this->assertGreaterThan(0, $converter->getTracks()->count());
    }

    /** @test */
    public function it_returns_formatted_data()
    {
        $formatted = (new AccTracksFromSgpConverter)->getFormatted();

        $this->assertGreaterThan(0, count($formatted));
        $this->assertGreaterThan(0, count($formatted[0]));
    }
}
