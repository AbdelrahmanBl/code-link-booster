<?php

namespace CodeLink\Booster\Notifications;

use CodeLink\Booster\Enums\NotifyBy;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use CodeLink\Booster\Traits\SendFcmNotification;
use CodeLink\Booster\Traits\SendMailNotification;
use CodeLink\Booster\Traits\StoreDatabaseNotification;

class MixedNotification extends Notification implements ShouldQueue
{
    use Queueable,
        StoreDatabaseNotification,
        SendFcmNotification,
        SendMailNotification;

    protected $target;

    protected $targetId;

    /**
     * tranlate key in locale must contain[title, body]
     *
     * @var string|null
     */
    protected $translation = null;

    protected $body = [];

    protected $via = [];

    /**
     * Create a new notification instance.
     */
    public function __construct($translation = null, $body = [], string $target = null, string $targetId = null, array|NotifyBy $via = [])
    {
        $this->body = $body;
        $this->translation = $translation;
        $this->target = $target;
        $this->targetId = $targetId;
        $this->via = $via;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return empty($this->via)
        ? config('booster.notifications.via')
        : function() {
            return is_array($this->via)
            ? array_map(
                fn($via) => $via === NotifyBy::FCM
                ? config('booster.notifications.fcm_channel')
                : $via->value,
                $this->via
            )
            : $this->via;
        };
    }
}
