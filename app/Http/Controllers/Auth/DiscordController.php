<?php

namespace App\Http\Controllers\Auth;

use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Http\Guzzle\Sgp\Get\Responses\LeagueViewsResponse;
use App\Http\Guzzle\Sgp\SgpApi;
use App\Models\Driver;
use App\Models\Invite;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Contracts\Factory as Socialite;
use App\Pipelines\ProcessDiscordRegistration\ProcessDiscordRegistrationPipeline;

class DiscordController extends Controller
{
    public static function routes()
    {
        Route::get('/auth/redirect', [self::class, 'redirectToDiscord'])->name('discordSend');
        Route::get('/auth/callback', [self::class, 'handleCallback'])->name('discordCallback');
    }

    protected Socialite $socialite;

    public function __construct(Socialite $socialite)
    {
        $this->socialite = $socialite;
    }

    public function redirectToDiscord()
    {
        return $this->socialite->driver('discord')
            ->scopes(['identify', 'guilds', 'email'])
            ->redirect();
    }


    public function handleCallback()
    {
        //TODO: Refactor this to a pipeline when we know it's working.

        $discordUserResponse = $this->socialite->driver('discord')->user();

        $discordUserId = $discordUserResponse->id;

        $user = User::whereHas('driver', function ($query) use ($discordUserId) {
            $query->where('discord_user_id', $discordUserId);
        })->first();


        if ($user) {
            if ($user->deactivated) return redirect('https://www.pornhub.com/');

            Auth::login($user);
            return redirect()->route('home');
        }

        //User with driver record doesn't exist, see if only a driver record does.

        $driver = Driver::whereDiscordUserId($discordUserId)->first();

        if ($driver) {
            $invite = Invite::generate($driver->id);
            return redirect()->route('invite.show', $invite);
        }

        //User and Driver records don't exist, see if they are in the league member list.
        $sgpApiResponse = app(LeagueViewsResponse::class);
        $member = $sgpApiResponse->findMemberByDiscordId($discordUserId);

        if ($member) {
            $driver = Driver::importFromSgp($member->userId);
            if ($driver->wasRecentlyCreated) {
                $invite = Invite::generate($driver->id);
                return redirect()->route('invite.show', $invite);
            } else {
                Auth::login($driver->user);
                return redirect()->route('home');
            }
        }

        //Next is to handle auto on-boarding into sgp.

        return 'Your account could not be found or created. ' .
            'Usually this means you do not have your discord account linked to your SGP account. ' .
            'Check the discord for support.';
    }
}
