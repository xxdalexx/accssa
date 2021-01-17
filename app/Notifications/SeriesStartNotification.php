<?php

namespace App\Notifications;

use App\Models\Series;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class SeriesStartNotification extends Notification
{
    use Queueable;

    protected $series;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Series $series)
    {
        $this->series = $series;
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
        $carNum = $notifiable->number;
        $message = "Friendly reminder that " . $this->series->name . " starts today.\n";

        if ($carNum) {
            $message .= "You currently have your car number set as " . $carNum . " on your tracker profile. ";
            $message .= "If you plan on using a livery with a different number assigned, please updated it here: ";
        } else {
            $message .= "You currently don't have a car number picked in your tracker profile. ";
            $message .= "Please go here and enter the number you plan on using for the series: ";
        }
        $message .= route('user.show');

        return DiscordMessage::create($message);
    }
}
