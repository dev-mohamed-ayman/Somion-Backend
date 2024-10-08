<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskCommentFile extends Model
{
    use HasFactory;

    protected function Path(): Attribute
    {
        return Attribute::make(
            get: fn($value) => asset($value),
        );
    }
}
