<?php

namespace App\Http\Resources\Api\Admin\Project\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
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
            'end_date' => $this->end_date,
            'bg_color' => $this->bg_color,
            'comments_count' => $this->comments()->count(),
            'employees' => $this->employees()->latest()->with('user')->get()->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'image' => $employee->user->image,
                ];
            }),
            'checklists_count' => $this->checklists()->count(),
            'checklist_completed_count' => $this->checklists()->where('completed', true)->count(),
        ];
    }
}
