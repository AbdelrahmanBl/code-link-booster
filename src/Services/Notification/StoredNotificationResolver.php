<?php

namespace CodeLink\Booster\Services\Notification;

class StoredNotificationResolver
{
    protected $notification;

    protected $title;

    protected $body;

    protected $link;

    protected $icon;

    protected $createdAt;

    protected $isRead;

    public function __construct($notification)
    {
        $this->notification = $notification->data;
        $this->createdAt = $notification->created_at?->diffForHumans();
        $this->isRead = !! $notification->read_at;

        if($translationKey = $this->notification['translation_key']) {
            $this->title = __("{$translationKey}.title");
            $this->body = __(
                "{$translationKey}.body",
                $this->notification['body']
            );
        }
        else {
            $this->title = $this->notification['body']['title'];
            $this->body = $this->notification['body']['body'];
        }
    }

    public function toArray()
    {
        $this->setIconAndLink();

        return [
            'icon' => $this->icon,
            'link' => $this->link,
            'target' => $this->notification['target'],
            'target_id' => $this->notification['target_id'],
            'title' => $this->title,
            'body' => $this->body,
            'created_at' => $this->createdAt,
            'is_read' => $this->isRead,
        ];
    }

    // ! this will be from front end...
    private function setIconAndLink()
    {
        $targetId = (int) $this->notification['target_id'];

        switch ($this->notification['target']) {
            case class_basename(\App\Models\Subscription::class):
                $this->link = route('user.subscription.show', $targetId);
                $this->icon = asset('theme/notifications/new-subscription.png');
                break;

            case class_basename(\App\Models\Order::class):
                $this->link = route('user.order.show', $targetId);
                $this->icon = asset('theme/notifications/new-order.png');
                break;

            case class_basename(\App\Models\Offer::class):
                $this->link = route('user.offer.show', $targetId);
                $this->icon = asset('theme/notifications/new-offer.jpg');
                break;

            default:
                $this->link = NULL;
                $this->icon = NULL;
                break;

        }
    }
}
