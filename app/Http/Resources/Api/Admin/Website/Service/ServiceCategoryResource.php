<?php

namespace App\Http\Resources\Api\Admin\Website\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryResource extends JsonResource
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
            'title' => $this->getTranslations('title'),
            'main_title' => $this->getTranslations('main_title'),
            'image' => $this->image,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'count_services' => $this->services()->count()
        ];
    }
}
