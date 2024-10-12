<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceCategory extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'title',
        'main_title',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'service_category_id', 'id');
    }
}
