<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class EmployeeJob extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title'];

    protected $fillable = [
        'title',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'employee_job_id', 'id');
    }
}
