<?php

namespace CodeLink\Booster\Traits;

use CodeLink\Booster\Services\FcmService;
use Illuminate\Support\Arr;

trait SendFcmNotification
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

    private FcmService $fcmService;

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFcm($notifiable)
    {
        $languageKey = config('booster.notifications.notifiable_language_key');
        $locale = $notifiable->{$languageKey};

        if($this->translation) {
            $title = __("{$this->translation}.title", [], $locale);
            $body = __("{$this->translation}.body", Arr::translateValues($this->body), $locale);
        }
        else {
            $title = $this->body['title'];
            $body = $this->body['body'];
        }

        $fcmService = config('booster.notifications.fcm_service');

        $this->fcmService = new $fcmService;

        return $this->fcmService->send($title, $body, $this->target, $this->targetId);
    }
}
