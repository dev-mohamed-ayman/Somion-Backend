<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function employeeJob()
    {
        return $this->belongsTo(EmployeeJob::class, 'employee_job_id', 'id');
    }

    public function employmentStatus()
    {
        return $this->belongsTo(EmploymentStatus::class, 'employment_status_id', 'id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }

    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
