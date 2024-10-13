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
            'bg_color' => $this->bg_color,
            'bg_image' => $this->bg_image,
            'users' => UserResource::collection($this->users),
            'employees' => EmployeeResource::collection($this->employees),
            'sections' => $this->sections()
                ->orderBy('order', 'asc')
                ->with(['tasks' => function ($tasks) {
                    $tasks->orderBy('order', 'asc')
                        ->select('id', 'title', 'section_id', 'bg_color')
                        ->with('checklists:id,task_id,text,completed');
                }])
                ->select('id', 'title', 'bg_color')
                ->get(),
        ];
    }
}
