<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
        $user = Socialite::driver('discord')->user();

        $status = app('DiscordAuthHandler')->setDiscordUser($user)->process();

        if ($status == 'loggedIn') {
            return redirect()->route('home');
        } else {
            return 'No account found. Go to the NWSR Discord to get set up with an account.';
        }
    }
}
