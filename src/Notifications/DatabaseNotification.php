<?php

namespace CodeLink\Booster\Notifications;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use CodeLink\Booster\Traits\StoreDatabaseNotification;
use Illuminate\Notifications\Notification;

class DatabaseNotification extends Notification
{
    use StoreDatabaseNotification;

    public $target;

    public $targetId;

    /**
     * tranlate key in locale must contain[title, body]
     *
     * @var string|null
     */
    public $locale = null;

    public $body = [];

    /**
     * Create a new notification instance.
     */
    public function __construct($locale = null, $body = [], string $target = null, string $targetId = null)
    {
        $this->locale = $locale;
        $this->body = $body;
        $this->target = $target;
        $this->targetId = $targetId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }
}
