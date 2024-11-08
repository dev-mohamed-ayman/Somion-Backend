<?php

namespace App\Http\Resources\Api\Admin\Project\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'title' => $this->title,
            'section_title' => $this->section->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'comments' => CommentResource::collection($this->comments()->latest()->get()),
            'checklists' => ChecklistResource::collection($this->checklists()->latest()->get()),
            'employees' => $this->employees()->latest()->with('user')->get()->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'image' => $employee->user->image,
                ];
            }),
            'comment_count' => $this->comments()->count(),
            'checklist_count' => $this->checklists()->count(),
            'checklist_completed_count' => $this->checklists()->where('completed', true)->count(),
        ];
    }
}
