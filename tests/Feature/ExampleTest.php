<?php

namespace Tests\Feature;

use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Http\Guzzle\Sgp\SgpApi;
use Database\Seeders\Testing\CreateMe;
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
}
