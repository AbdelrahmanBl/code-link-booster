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

    protected $target_id;

    protected $locale = '';

    protected $body = [];

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFcm($notifiable)
    {
        return FcmMessage::create()
                        ->setData([
                            'target' => $this->target,
                            'id' => $this->target_id,
                        ])
                        ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                                ->setTitle(__("{$this->locale}.title"))
                                ->setBody(
                                    __("{$this->locale}.body", Arr::translateValues($this->body))
                                )
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