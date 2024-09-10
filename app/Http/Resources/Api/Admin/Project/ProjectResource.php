<?php

namespace App\Http\Resources\Api\Admin\Project;

use App\Http\Resources\Api\Admin\Employee\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'users' => $this->users,
            'employees' => EmployeeResource::collection($this->employees),
            'client' => $this->client,
            'notes' => $this->notes,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'currency' => $this->end_date,
            'total_amount' => $this->end_date,
            'paid_amount' => $this->end_date,
            'remaining_amount' => $this->end_date,
            'payment_status' => $this->end_date,
            'project_status' => $this->end_date,
            'priority' => $this->end_date,
        ];
    }
}
