<?php

namespace App\Http\Resources\Api\Admin\employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'name' => $this->employee->user->name,
            'image' => $this->employee->user->image,
            'email' => $this->employee->user->email,
            'phone' => $this->employee->user->phone,
        ];
    }
}
