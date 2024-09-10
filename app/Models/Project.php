<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'project_employee');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
