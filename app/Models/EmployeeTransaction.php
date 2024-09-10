<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['is_applied'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }


}
