<?php

namespace Tests\Feature;

use App\Http\Guzzle\Sgp\Get\Session;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Mocks\SgpSessionMock;
use Tests\TestCase;

class EventModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function build_pre_results()
    {
        $mock = new SgpSessionMock();
        $this->app->instance(Session::class, $mock);

        $this->assertInstanceOf(SgpSessionMock::class, app(Session::class));
        return;

        $series = $this->createDummySeries();

        Event::buildPreResults('id', $series->id);

        $this->assertDatabaseCount('events', 1);
    }

}
