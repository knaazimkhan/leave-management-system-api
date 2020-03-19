<?php

namespace App\Http\Resources;

use App\Http\Resources\LeaveApplyResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LeaveApplyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'data' => LeaveApplyResource::collection($this->collection)
        ];
    }
}
