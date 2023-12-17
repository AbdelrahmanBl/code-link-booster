<?php

namespace CodeLink\Booster\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'target' => $this->data['target'],
            'target_id' => $this->data['target_id'],
            ...$this->when($locale = $this->data['locale'],
                [
                    'title' => __("{$locale}.title"),
                    'body' => __(
                        "{$locale}.body",
                        $this->data['body']
                    ),
                ],
                [
                    'title' => $this->data['body']['title'],
                    'body' => $this->data['body']['body'],
                ]
            ),
            'created_at' => $this->created_at?->diffForHumans(),
            'is_read' => !! $this->read_at,
        ];
    }
}
