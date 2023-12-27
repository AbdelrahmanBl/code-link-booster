<?php

namespace CodeLink\Booster\Traits;

trait StoreDatabaseNotification
{
    protected $target;

    protected $targetId;

    /**
     * tranlate key in locale must contain[title, body]
     *
     * @var string|null
     */
    protected $translation = null;

    protected $body = [];

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
            'translation' => $this->translation,
            'body' => $this->body,
        ];
    }
}
