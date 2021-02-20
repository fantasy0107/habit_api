<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{
    public static $wrap = 'topic';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->item();
    }

    public function with($request)
    {
        return [
            'id' => $this->id,
            'db' => [
                'topic' => $this->item()
            ]
        ];
    }

    private function item()
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "title" => $this->title,
            "content" => $this->content,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
            "tag_id" => $this->when(true, 123123)
        ];
    }
}
