<?php

namespace CodeLink\Booster\Notifications;

use Illuminate\Bus\Queueable;
use NotificationChannels\Fcm\FcmChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use CodeLink\Booster\Traits\SendFcmNotification;

class FcmNotification extends Notification implements ShouldQueue
{
    use Queueable,
        SendFcmNotification;

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
            return [FcmChannel::class];
        }
}
