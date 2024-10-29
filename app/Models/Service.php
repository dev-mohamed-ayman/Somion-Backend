<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'title',
        'main_title',
        'sub_title',
        'short_description',
        'description',
    ];

    protected function Image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset($value) : null
        );
    }

    protected function MainImage(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset($value) : null
        );
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id', 'id');
    }

    public function features()
    {
        return $this->hasMany(ServiceFeature::class, 'service_id', 'id');
    }

    public function plans()
    {
        return $this->hasMany(ServicePlane::class, 'service_id', 'id');
    }
}
