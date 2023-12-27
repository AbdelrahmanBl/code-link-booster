<?php

namespace CodeLink\Booster\Traits;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Arr;

trait SendMailNotification
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(__("{$this->translation}.title"))
                    ->line(__("{$this->translation}.body", Arr::translateValues($this->body)));
    }
}
