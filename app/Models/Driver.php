<?php

namespace App\Models;

use App\Http\Guzzle\Sgp\SgpBase;
use Illuminate\Notifications\Notifiable;
use App\Notifications\DiscordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends BaseModel
{
    use HasFactory, Notifiable;

    protected static function boot()
    {
        parent::boot();

        //Change to actual event if anything else should be done when a driver is created.
        static::created(function ($driver) {
            $score = new DriverScore;
            $driver->score()->save($score);
        });
    }

    public static function importFromSgp(string $sgpId): self
    {
        $apiResponse = (new SgpBase)->getLeagueMemberList()->members->$sgpId;

        $newDriver = self::updateOrCreate([
            'driver_name' => $apiResponse->name,
            'sgp_id' => $apiResponse->userId
        ]);

        $newDriver->calculateDriverScore();

        return $newDriver;
    }

    public function score()
    {
        return $this->hasOne(DriverScore::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function invite()
    {
        return $this->hasOne(Invite::class);
    }

    public function getDisplayNameAttribute()
    {
        if ($this->number) {
            return $this->driver_name . ' #' . $this->number;
        }
        return $this->driver_name;
    }

    public function getDisplayNameReversedAttribute()
    {
        if ($this->number) {
            return '#' . $this->number . ' ' . $this->driver_name;
        }
        return $this->driver_name;
    }

    public function getCurrentSplitAttribute()
    {
        $cuts = [
            'pro' => 3000,
            'silver' => 4000,
        ];

        if ($this->driver_score == 0) {
            return 'No Score';
        }

        if ($this->driver_score < $cuts['pro']) {
            return 'Pro';
        }

        if ($this->driver_score < $cuts['silver']) {
            return 'Silver';
        }

        return 'AM';
    }

    public function calculateDriverScore()
    {
        $this->driver_score = $this->score->calculateScore();
        $this->save();

        return $this;
    }

    public function routeNotificationForDiscord()
    {
        return $this->discord_private_channel_id;
    }

    public function sendDiscordDM(string $message)
    {
        $this->notify(new DiscordNotification($message));
    }

    public static function massDiscordMessage(string $message)
    {
        $all = self::whereNotNull('discord_private_channel_id')->get();
        foreach ($all as $driver) {
            $driver->sendDiscordDM($message);
        }
    }
}
