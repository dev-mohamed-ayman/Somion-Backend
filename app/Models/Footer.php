<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Footer extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];
    public $translatable = [
        'location',
        'subscription_paragraph',
        'copyright',
    ];

    protected $casts = [
        'emails' => 'array'
    ];
}
