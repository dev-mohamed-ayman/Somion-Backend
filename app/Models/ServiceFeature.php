<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceFeature extends Model
{
    use HasFactory, HasTranslations;

    protected function Image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset($value) : null
        );
    }

    public $translatable = ['title', 'description'];
}
