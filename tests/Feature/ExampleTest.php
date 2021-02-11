<?php

namespace Tests\Feature;

use App\Models\Driver;
use App\Models\Event;
use App\Models\EventEntry;
use Database\Seeders\Testing\CreateMe;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_me_seeder()
    {
        $this->seed(CreateMe::class);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('drivers', 1);
    }

    /** @test */
    public function driver_factory()
    {
        Driver::factory()->create();
        $this->assertDatabaseCount('drivers', 1);
    }

    /** @test */
    public function event_factory()
    {
        Event::factory()->create();
        $this->assertDatabaseCount('events', 1);
    }

    /** @test */
    public function event_entries()
    {
        EventEntry::factory()->create();
        $this->assertDatabaseCount('events', 1)
            ->assertDatabaseCount('drivers', 1)
            ->assertDatabaseCount('series', 1)
            ->assertDatabaseCount('event_entries', 1);
    }
}
