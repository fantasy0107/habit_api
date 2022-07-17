<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class IndexProjectResource extends BaseResource
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
            'projects' => $this['projects']
        ];
    }
}
