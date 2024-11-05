<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Imprint extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'body', 'meta_description', 'meta_keywords',];
    protected $guarded = [];
}
