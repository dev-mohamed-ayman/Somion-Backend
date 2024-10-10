<?php

namespace App\Http\Resources\Api\Admin\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'users' => UserResource::collection($this->users),
            'employees' => EmployeeResource::collection($this->employees),
            'sections' => $this->sections()
                ->orderBy('order', 'asc')
                ->with(['tasks' => function ($tasks) {
                    $tasks->orderBy('order', 'asc')->select('id','title','section_id');
                }])
                ->select('id', 'title', 'bg_color')
                ->get(),
        ];
    }
}
