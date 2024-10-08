<?php

namespace App\Http\Resources\Api\Admin\employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'type' => $this->type,
            'reason' => $this->reason,
            'name' => $this->employee->user->name,
            'image' => $this->employee->user->image,
            'email' => $this->employee->user->email,
            'phone' => $this->employee->user->phone,
        ];
    }
}
