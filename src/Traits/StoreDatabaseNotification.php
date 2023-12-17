<?php

namespace CodeLink\Booster\Traits;

trait StoreDatabaseNotification
{
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'target' => $this->target,
            'target_id' => $this->targetId,
            'locale' => $this->locale,
            'body' => $this->body,
        ];
    }
}
