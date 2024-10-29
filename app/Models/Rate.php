<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected function Image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset($value) : 'https://ui-avatars.com/api/?name=' . $this->first_name . ' ' . $this->last_name
        );
    }

    public function scopeActive(Builder $query)
    {
        $query->where('status', true);
    }
}
