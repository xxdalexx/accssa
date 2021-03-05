<?php

namespace App\Models;

use App\Http\Guzzle\Sgp\Get\Responses\LeagueViewsResponse;
use Illuminate\Notifications\Notifiable;
use App\Notifications\DiscordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use NotificationChannels\Discord\Discord;

/**
 * @property mixed        discord_private_channel_id
 * @property mixed|string discord_user_id
 * @property DriverScore  score
 */
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

    public static function importFromSgp(string $sgpId)
    {
        $sgpApiResponse = app(LeagueViewsResponse::class);

        //api connection failed
        if (!$sgpApiResponse) return false;

        $member = $sgpApiResponse->findMemberBySgpId($sgpId);

        $newDriver = self::updateOrCreate([
            'driver_name' => $member->name,
            'sgp_id'      => $member->userId
        ]);

        //$newDriver->calculateDriverScore(); NEEDS REFACTORED API CLASS

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
            'pro'    => 3000,
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

    public function setDiscordUserIdAttribute($value)
    {
        $this->attributes['discord_user_id']            = $value;
        $this->attributes['discord_private_channel_id'] = app(Discord::class)->getPrivateChannel($value);
    }

    public function championshipEligible()
    {
        if ($this->getCurrentSplitAttribute() == 'No Score') {
            return false;
        }
        return true;
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
        if ($this->routeNotificationForDiscord()) {
            $this->notify(new DiscordNotification($message));
        }
    }

    public static function massDiscordMessage(string $message)
    {
        $all = self::whereNotNull('discord_private_channel_id')->get();
        foreach ($all as $driver) {
            $driver->sendDiscordDM($message);
        }
    }
}
