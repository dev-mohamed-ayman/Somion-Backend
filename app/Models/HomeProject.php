<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomeProject extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'description'];


    public function categories()
    {
        return $this->belongsToMany(HomeProjectCategory::class, 'project_category');
    }

    public function images()
    {
        return $this->hasMany(HomeProjectImage::class, 'home_project_id', 'id');
    }
}
