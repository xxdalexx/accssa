<?php

namespace Tests\Feature;

use App\Importers\AccTracksFromSgpConverter;
use App\Models\AccTrack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccTracksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_formatted_data()
    {
        AccTrack::insert([
            'track_id' => 'should not exist',
            'name' => 'name',
            'length' => 0,
            'max_entries' => 0
        ]);


        AccTrack::importFromSgpJson();


        $tracks = (new AccTracksFromSgpConverter)->getFormatted();

        $this->assertDatabaseCount('acc_tracks', count($tracks));
        $firstRecord = AccTrack::first();
        $firstImport = $tracks[0];

        $this->assertEquals($firstRecord->track_id, $firstImport['track_id']);
        $this->assertEquals($firstRecord->name, $firstImport['name']);
        $this->assertEquals($firstRecord->length, $firstImport['length']);
        $this->assertEquals($firstRecord->max_entries, $firstImport['max_entries']);
    }

    /** @test */
    public function it_runs_on_migration() //Will fail after migrations squashed.
    {
        $tracks = (new AccTracksFromSgpConverter)->getFormatted();

        $this->assertDatabaseCount('acc_tracks', count($tracks));
        $firstRecord = AccTrack::first();
        $firstImport = $tracks[0];

        $this->assertEquals($firstRecord->track_id, $firstImport['track_id']);
        $this->assertEquals($firstRecord->name, $firstImport['name']);
        $this->assertEquals($firstRecord->length, $firstImport['length']);
        $this->assertEquals($firstRecord->max_entries, $firstImport['max_entries']);
    }

    /** @test */
    public function it_runs_from_a_command()
    {
        AccTrack::truncate();
        $this->artisan('sgp:rebuild-acc-tracks')
             ->expectsOutput('Tracks Imported.');

        $tracks = (new AccTracksFromSgpConverter)->getFormatted();
        $this->assertDatabaseCount('acc_tracks', count($tracks));
        $firstRecord = AccTrack::first();
        $firstImport = $tracks[0];
        $this->assertEquals($firstRecord->track_id, $firstImport['track_id']);
        $this->assertEquals($firstRecord->name, $firstImport['name']);
        $this->assertEquals($firstRecord->length, $firstImport['length']);
        $this->assertEquals($firstRecord->max_entries, $firstImport['max_entries']);
    }
}
