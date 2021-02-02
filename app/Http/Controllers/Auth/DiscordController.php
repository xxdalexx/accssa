<?php

namespace App\Http\Controllers\Auth;

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
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToDiscord()
    {
        return Socialite::driver('discord')
            ->scopes(['identify', 'guilds', 'email'])
            ->redirect();
    }

    /**
     * Obtain the user information from Discord.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleCallback()
    {
        $discordUserResponse = Cache::remember('discordTesting', 9999, function () {
            return Socialite::driver('discord')->user();
        });

        $discordUserId = $discordUserResponse->id;

        $user = User::whereHas('driver', function ($query) use ($discordUserId) {
            $query->where('discord_user_id', $discordUserId);
        });

        if ($user) {
            Auth::login($user);
            return redirect()->route('home');
        } else {
            $returnRoute = ProcessDiscordRegistrationPipeline::run($discordUserResponse);
            return redirect()->route($returnRoute);
        }
    }
}
