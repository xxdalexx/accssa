<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Notifications\DiscordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'driver_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        //Change to actual event if anything else should be done when a driver is created.
        static::created(function ($newUser) {
            $dale = User::first();
            $dale->sendDiscordDM($newUser->name . ' Signed up.');
        });
    }

    public function routeNotificationForDiscord()
    {
        return $this->driver->discord_private_channel_id;
    }

    public function sendDiscordDM(string $message)
    {
        $this->notify(new DiscordNotification($message));
    }

    public function displayRoles(): string
    {
        $string = '';
        $roleNames = $this->getRoleNames();
        foreach($roleNames as $role) {
            $string .= ucwords($role) . ' ';
        }
        return $string;
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
