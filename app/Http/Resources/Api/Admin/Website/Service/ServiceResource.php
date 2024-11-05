<?php

namespace App\Http\Resources\Api\Admin\Website\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $category = new ServiceCategoryResource($this->category);
        $categoryArray = $category->toArray($request);
        unset($categoryArray['count_services']);

        return [
            'id' => $this->id,
            'title' => $this->getTranslations('title'),
            'main_title' => $this->getTranslations('main_title'),
            'sub_title' => $this->getTranslations('sub_title'),
            'short_description' => $this->getTranslations('short_description'),
            'description' => $this->getTranslations('description'),
            'image' => $this->image,
            'main_image' => $this->main_image,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'category' => $categoryArray,
        ];
    }
}
