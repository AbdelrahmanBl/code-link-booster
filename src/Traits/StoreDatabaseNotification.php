<?php

namespace CodeLink\Booster\Traits;

trait StoreDatabaseNotification
{
    protected $target;

    protected $target_id;

    /**
     * tranlate key in locale must contain[title, body]
     *
     * @var mixed
     */
    protected $locale = NULL;

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
            'target_id' => $this->target_id,
            'locale' => $this->locale,
            'body' => $this->body,
        ];
    }
}
