<?php

namespace App\Http\Resources\Api\Admin\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Admin\Project\Task\CommentResource;

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
                        ->select('id', 'title', 'section_id', 'bg_color', 'end_date', 'start_date')
                        ->with([
                            'checklists:id,task_id,text,completed',
                            'comments' => function ($comments) {
                                $comments->select('id', 'task_id', 'comment', 'created_at', 'user_id')
                                    ->with('user:id,name,image')
                                    ->with('files')
                                    ->get();
                            }
                        ]);
                }])
                ->select('id', 'title', 'bg_color')
                ->get(),
        ];
    }
}
