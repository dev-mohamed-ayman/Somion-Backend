<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['title', 'description', 'body', 'image', 'meta_description', 'meta_tags'];
    protected $guarded = [];

    protected $casts = [
        'image' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->order = self::max('order') + 1;
        });
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset($value) : null
        );
    }

    protected function scopeOrder(Builder $query)
    {
        $query->orderBy('order', 'asc');
    }

    public function type()
    {
        return $this->belongsTo(BlogType::class, 'blog_type_id', 'id');
    }
}
