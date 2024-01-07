<?php

namespace CodeLink\Booster\Services;

use NotificationChannels\Fcm\FcmMessage;
use CodeLink\Booster\Contracts\FcmContract;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;

class FcmService implements FcmContract
{
    public function send(string $title, string $body, ?string $target, ?string $targetId)
    {
        return FcmMessage::create()
        ->setData([
            'target' => $target,
            'id' => $targetId,
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
            ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios'))
        );
    }
}
