<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function checklists()
    {
        return $this->hasMany(TaskChecklist::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'task_employee');
    }
}
