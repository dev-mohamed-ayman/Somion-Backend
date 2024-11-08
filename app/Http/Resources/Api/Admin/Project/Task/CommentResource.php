<?php

namespace App\Http\Resources\Api\Admin\Project\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'comment' => $this->comment,
            'name' => $this->user->name,
            'image' => $this->user->image,
            'files' => $this->files()->select('id', 'path', 'name')->get(),
            'created' => $this->created_at,
        ];
    }
}
