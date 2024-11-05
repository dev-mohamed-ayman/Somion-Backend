<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomeSetting extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['title', 'meta_description', 'meta_keywords'];
    protected $guarded = [];
}
