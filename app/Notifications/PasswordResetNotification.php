<?php

namespace App\Notifications;

use App\Models\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class PasswordResetNotification extends Notification
{
    use Queueable;

    public $reset;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ResetPassword $reset)
    {
        $this->reset = $reset;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DiscordChannel::class];
    }

    public function toDiscord($notifiable)
    {
        $message = 'A password reset has been triggered by ' . Auth::user()->name . '. ';
        $message .= 'Visit ' . $this->reset->link();
        return DiscordMessage::create($message);
    }
}
