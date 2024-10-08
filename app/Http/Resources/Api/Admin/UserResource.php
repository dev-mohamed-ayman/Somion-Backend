<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'image' => $this->image,
            'name' => $this->name,
            'phone' => $this->phone,
            'username' => $this->username,
            'email' => $this->email,
            'status' => $this->status,
            'type' => $this->type,
            'is_active' => (bool)$this->is_active,
            'roles' => $this->getRoleNames(),
        ];
    }
}
