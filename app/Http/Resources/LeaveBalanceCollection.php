<?php

namespace App\Http\Resources;

use App\Http\Resources\LeaveBalanceResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LeaveBalanceCollection extends ResourceCollection
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
            'data' => LeaveBalanceResource::collection($this->collection)
        ];
    }
}
