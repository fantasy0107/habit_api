<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HabitResource extends JsonResource
{
    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" =>  $this->user_id,
            "name" =>  $this->name,
            "content" =>  $this->content,
            "created_at" =>  $this->created_at,
        ];
    }
}
