<?php

namespace Tests\Feature;

use App\Models\AccCar;
use App\Models\AccTrack;
use App\Models\Driver;
use App\Models\TrackTime;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TrackTimesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_has_relationships()
    {
        [$driver, $user] = $this->createMe();
        $trackTime = TrackTime::create([
            'sim' => 'acc',
            'driver_id' => $driver->id,
            'track_id' => AccTrack::first()->track_id,
            'car_id' => AccCar::first()->id,
            'lap_time' => 90000
        ]);

        $this->assertInstanceOf(Driver::class, $trackTime->driver);
        $this->assertInstanceOf(AccTrack::class, $trackTime->track);
        $this->assertInstanceOf(AccCar::class, $trackTime->car);
    }

    /** @test */
    public function it_calculates_deltas_on_save()
    {
        $alienTime = TrackTime::create([
            'sim' => 'acc',
            'driver_id' => 0,
            'track_id' => AccTrack::first()->track_id,
            'car_id' => AccCar::first()->id,
            'lap_time' => 101900
        ]);
        [$driver, $user] = $this->createMe();
        $trackTime = TrackTime::create([
            'sim' => 'acc',
            'driver_id' => $driver->id,
            'track_id' => AccTrack::first()->track_id,
            'car_id' => AccCar::first()->id,
            'lap_time' => 103900
        ]);

        $this->assertNotNull($trackTime->per_km_time);
        $this->assertEquals(2000, $trackTime->lap_delta);
        $this->assertNotNull($trackTime->per_km_delta);
    }

    /** @test */
    public function it_does_not_calculate_with_no_comparison_record()
    {
        [$driver, $user] = $this->createMe();
        $trackTime = TrackTime::create([
            'sim' => 'acc',
            'driver_id' => $driver->id,
            'track_id' => AccTrack::first()->track_id,
            'car_id' => AccCar::first()->id,
            'lap_time' => 103900
        ]);

        $this->assertNotNull($trackTime->per_km_time);
        $this->assertEquals(0, $trackTime->lap_delta);
        $this->assertEquals(0, $trackTime->per_km_delta);
    }

    /** @test */
    public function it_adds_a_car_type_if_it_exists_on_car_model()
    {
        [$driver, $user] = $this->createMe();
        $trackTime = TrackTime::create([
            'sim' => 'acc',
            'driver_id' => $driver->id,
            'track_id' => AccTrack::first()->track_id,
            'car_id' => AccCar::first()->id,
            'lap_time' => 103900
        ]);

        $this->assertEquals('GT3', $trackTime->car_type);
    }

    /** @test */
    public function it_calculates_deltas_based_on_type()
    {
        $alienTime = TrackTime::create([
            'sim' => 'acc',
            'driver_id' => 0,
            'track_id' => AccTrack::first()->track_id,
            'car_id' => 5,
            'lap_time' => 101900
        ]);
        [$driver, $user] = $this->createMe();
        $trackTime = TrackTime::create([
            'sim' => 'acc',
            'driver_id' => $driver->id,
            'track_id' => AccTrack::first()->track_id,
            'car_id' => 6, //ids 5 and 6 are both of gt3 type
            'lap_time' => 103900
        ]);

        $this->assertNotNull($trackTime->per_km_time);
        $this->assertEquals(2000, $trackTime->lap_delta);
        $this->assertNotNull($trackTime->per_km_delta);
    }

    /** @test */
    public function it_throws_exception_on_duplicate_entries()
    {
        //This is currently only testing the unique key when there are car types.
        TrackTime::create([
            'sim' => 'acc',
            'driver_id' => 1,
            'track_id' => AccTrack::first()->track_id,
            'car_id' => 6,
            'lap_time' => 103900
        ]);
        try {
            TrackTime::create([
                'sim' => 'acc',
                'driver_id' => 1,
                'track_id' => AccTrack::first()->track_id,
                'car_id' => 6,
                'lap_time' => 103900
            ]);
        } catch (QueryException $e) {
            $this->assertStringStartsWith('Duplicate entry', $e->errorInfo[2]);
            $this->assertDatabaseCount('track_times', 1);
        }
    }

    /** @test */
    public function it_()
    {
        Notification::fake();
    }
}
