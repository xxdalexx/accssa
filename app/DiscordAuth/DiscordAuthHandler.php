<?php

namespace App\DiscordAuth;

use App\Models\Driver;
use Illuminate\Support\Facades\Auth;

class DiscordAuthHandler
{
    protected $discordUser;

    public function setDiscordUser($discordUser)
    {
        $this->discordUser = $discordUser;
        return $this;
    }

    public function process()
    {
        $driver = Driver::where('discord_user_id', $this->discordUser->id)->with('user')->first();
        if (!$driver) return 'driverError';
        if (!$driver->user()->exists()) return 'noUser';
        Auth::login($driver->user);
        return 'loggedIn';
    }
}
