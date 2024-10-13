<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomeProjectSection extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'description', 'sub_title'];

    protected $guarded = [];
}
