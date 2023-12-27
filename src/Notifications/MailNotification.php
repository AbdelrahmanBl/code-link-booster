<?php

namespace CodeLink\Booster\Notifications;

use CodeLink\Booster\Traits\SendMailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MailNotification extends Notification implements ShouldQueue
{
    use Queueable,
        SendMailNotification;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }
}
