<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomeProjectCategory extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    public function projects()
    {
        return $this->belongsToMany(HomeProject::class, 'project_category', 'home_project_category_id', 'home_project_id');
    }

}
