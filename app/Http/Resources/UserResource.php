<?php

namespace App\Http\Resources;

use App\Http\Resources\LeaveApplyResource;
use App\Http\Resources\LeaveBalanceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'balance' => LeaveBalanceResource::collection($this->balance),
            'leave' => LeaveApplyResource::collection($this->apply)
        ];
    }
}
