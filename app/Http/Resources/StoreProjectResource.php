<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class StoreProjectResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'project' => $this['project']
        ];
    }
}
