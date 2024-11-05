<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BlogType extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['name'];
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->order = self::max('order') + 1;
        });
    }

    protected function scopeOrder(Builder $query)
    {
        $query->orderBy('order', 'asc');
    }

    protected function scopeShow(Builder $query)
    {
        $query->where('show', true);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'blog_type_id', 'id');
    }


}
