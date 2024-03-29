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
            "title" =>  $this->title,
            "description" =>  $this->description,
            "start_date" =>  $this->start_date->toDateString(),
            "end_date" =>  $this->end_date,
            "completion" =>  $this->completion,
            "completion_count" =>  $this->completionCount,
            "recordDates" => $this->when(count($this->records), $this->recordsDate),
            "repeat_type" =>  $this->repeat_type,
            "created_at" =>  $this->created_at,
            "updated_at" =>  $this->updated_at,
        ];
    }
}
