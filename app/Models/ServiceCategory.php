<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceCategory extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'title',
        'main_title',
        'meta_description',
        'meta_keywords'
    ];

    public function Image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset($value) : null
        );
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'service_category_id', 'id');
    }
}
