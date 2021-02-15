<?php

namespace Tests\Feature;

use App\Importers\AccTracksFromSgpConverter;
use App\Importers\AcTracksFromSgpConverter;
use App\Models\Track;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TracksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_acc_formatted_data()
    {
        Track::truncate();
        $tracks = (new AccTracksFromSgpConverter)->getFormatted();


        Track::insert($tracks);


        $this->assertDatabaseCount('tracks', count($tracks));
        $firstImport = $tracks[0];
        $firstRecord = Track::firstWhere('track_id', $firstImport['track_id']);

        $this->assertEquals($firstImport['name'], $firstRecord->name);
        $this->assertEquals($firstImport['length'], $firstRecord->length);
        $this->assertEquals('acc', $firstRecord->sim);
        $this->assertEquals($firstImport['max_entries'], $firstRecord->max_entries);
    }

    /** @test */
    public function it_imports_ac_formatted_data()
    {
        Track::truncate();
        $tracks = (new AcTracksFromSgpConverter())->getFormatted();


        Track::insert($tracks);


        $this->assertDatabaseCount('tracks', count($tracks));
        $firstImport = $tracks[0];
        $firstRecord = Track::firstWhere('track_id', $firstImport['track_id']);

        $this->assertNotNull($firstRecord->name);
        $this->assertNotNull($firstRecord->length);
        $this->assertNotNull($firstRecord->sim);
        $this->assertNotNull($firstRecord->max_entries);

        $this->assertEquals($firstImport['name'], $firstRecord->name);
        $this->assertEquals($firstImport['length'], $firstRecord->length);
        $this->assertEquals('ac', $firstRecord->sim);
        $this->assertEquals($firstImport['max_entries'], $firstRecord->max_entries);
    }

    /** @test */
    public function it_runs_from_a_command()
    {
        $this->artisan('sgp:rebuild-acc-tracks')
             ->expectsOutput('Tracks Imported.');

        $count = count((new AccTracksFromSgpConverter)->getFormatted());
        $count += count((new AcTracksFromSgpConverter)->getFormatted());
        $this->assertDatabaseCount('tracks', $count);
    }
}
