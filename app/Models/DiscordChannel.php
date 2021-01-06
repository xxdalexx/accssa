<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Notifications\DiscordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscordChannel extends BaseModel
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    public function routeNotificationForDiscord()
    {
        return $this->snowflake;
    }

    public function message($message)
    {
        $this->notify(new DiscordNotification($message));
    }
}
