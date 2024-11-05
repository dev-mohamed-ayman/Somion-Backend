<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContactSection extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'first_title',
        'second_title',
        'three_title',
        'four_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $guarded = [];
}
