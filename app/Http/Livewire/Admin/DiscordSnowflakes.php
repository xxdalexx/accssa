<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Driver;
use Livewire\Component;
use NotificationChannels\Discord\Discord;

class DiscordSnowflakes extends Component
{
    public $drivers;

    public function mount()
    {
        $this->drivers = Driver::select(['id', 'driver_name', 'discord_user_id', 'discord_private_channel_id'])->get()->toArray();
    }

    public function snowflake($key)
    {
        $driverId = $this->drivers[$key]['id'];
        $discordId = $this->drivers[$key]['discord_user_id'];

        $driver = Driver::find($driverId);
        $driver->discord_user_id = $discordId;
        $driver->discord_private_channel_id = app(Discord::class)->getPrivateChannel($discordId);
        $driver->save();
        $this->drivers[$key]['success'] = true;
    }

    public function render()
    {
        return view('livewire.admin.discord-snowflakes');
    }
}
