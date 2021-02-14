<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TargetResource extends JsonResource
{
    /**
     * Indicates if the resource's collection keys should be preserved.
     *
     * @var bool
     */
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'picture' => $this->picture,
            'step' => $this->step,
            'updated_at' => $this->updated_at,
            'updated_at_datetime' => $this->updated_at->toDateTimeString(),
            'created_at' => $this->created_at,
        ];
    }
}
