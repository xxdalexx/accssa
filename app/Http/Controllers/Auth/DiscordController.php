<?php

namespace App\Http\Controllers\Auth;

use App\Http\Guzzle\Sgp\SgpApi;
use App\Models\Driver;
use App\Models\Invite;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Pipelines\ProcessDiscordRegistration\ProcessDiscordRegistrationPipeline;

class DiscordController extends Controller
{
    public static function routes()
    {
        Route::get('/auth/redirect', [self::class, 'redirectToDiscord'])->name('discordSend');
        Route::get('/auth/callback', [self::class, 'handleCallback'])->name('discordCallback');
    }
    /**
     * Redirect the user to the Discord authentication page.
     */
    public function redirectToDiscord()
    {
        return Socialite::driver('discord')
            ->scopes(['identify', 'guilds', 'email'])
            ->redirect();
    }

    /**
     * Obtain the user information from Discord.
     */
    public function handleCallback()
    {
        //TODO: Refactor this to a pipeline when we know it's working.

        $discordUserResponse = Socialite::driver('discord')->user();

        $discordUserId = $discordUserResponse->id;

        $user = User::whereHas('driver', function ($query) use ($discordUserId) {
            $query->where('discord_user_id', $discordUserId);
        })->first();


        if ($user) {
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
        $memberList = collect(SgpApi::memberList()->members);

        $member = $memberList->firstWhere('discord.id', $discordUserId);

        if ($member) {
            $driver = Driver::importFromSgp($member->userId);
            $invite = Invite::generate($driver->id);
            return redirect()->route('invite.show', $invite);
        }

        //Next is to handle auto on-boarding into sgp.

        return 'Your account could not be found or created. ' .
            'Usually this means you do not have your discord account linked to your SGP account. ' .
            'Check the discord for support.';
    }
}
