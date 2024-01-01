<?php

namespace CodeLink\Booster\Traits;

use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFcm($notifiable)
    {
        if($this->translation) {
            $title = __("{$this->translation}.title");
            $body = __("{$this->translation}.body", Arr::translateValues($this->body));
        }
        else {
            $title = $this->body['title'];
            $body = $this->body['body'];
        }

        return FcmMessage::create()
                        ->setData([
                            'target' => $this->target,
                            'id' => $this->targetId,
                        ])
                        ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                                ->setTitle($title)
                                ->setBody($body)
                                ->setImage(''))
                        ->setAndroid(
                            AndroidConfig::create()
                                ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                                ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
                        )->setApns(
                            ApnsConfig::create()
                                ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }
}
