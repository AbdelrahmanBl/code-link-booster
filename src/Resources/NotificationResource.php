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
            'created_at' => $this->created_at?->diffForHumans(),
            'is_read' => !! $this->read_at,
            ...match(true) {
                !! ($translation = $this->data['translation']) => [
                    'title' => __("{$translation}.title"),
                    'body' => __(
                        "{$translation}.body",
                        $this->data['body']
                    ),
                ],
                default => [
                    'title' => $this->data['body']['title'],
                    'body' => $this->data['body']['body'],
                ]
            },
        ];
    }
}
