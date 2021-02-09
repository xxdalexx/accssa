<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\DiscordController;
use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Models\Invite;
use Database\Seeders\Testing\CreateMe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use MartinBean\Laravel\Socialite\DiscordProvider;
use Tests\Mocks\SgpLeagueViewsMock;
use Tests\TestCase;

class DiscordLoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $sgpCallMock = new SgpLeagueViewsMock();

        $this->app->instance(LeagueViews::class, $sgpCallMock);
        $this->mockSocialite('324060102770556933');
    }

    /** @test */
    public function it_logs_in_a_user()
    {
        $this->createMe();

        $this->call('GET', '/auth/callback');

        $this->assertNotNull(Auth::user());
    }

    /** @test */
    public function it_creates_invite_when_driver_exists_but_user_doesnt()
    {
        $this->createMyDriver();
        $this->assertDatabaseCount('invites', 0);

        $response = $this->call('GET', '/auth/callback');

        $this->assertDatabaseCount('invites', 1);
        $invite = Invite::first();
        $response->assertRedirect(route('invite.show', $invite));
    }

    /** @test */
    public function it_imports_the_driver_when_it_doesnt_exist()
    {
        $this->withoutExceptionHandling();

        $this->assertDatabaseCount('invites', 0);
        $this->assertDatabaseCount('drivers', 0);

        $response = $this->call('GET', '/auth/callback');

        $this->assertDatabaseCount('drivers', 1);
        $this->assertDatabaseCount('invites', 1);

        $invite = Invite::first();
        $response->assertRedirect(route('invite.show', $invite));

    }

    protected function mockSocialite($id)
    {
        $socialiteUser = $this->createMock(SocialiteUser::class);
        $socialiteUser->id = $id;

        $provider = $this->createMock(DiscordProvider::class);
        $provider->expects($this->any())
            ->method('user')
            ->willReturn($socialiteUser);

        $stub = $this->createMock(Socialite::class);
        $stub->expects($this->any())
            ->method('driver')
            ->willReturn($provider);

        // Replace Socialite Instance with our mock
        $this->app->instance(Socialite::class, $stub);
    }
}
