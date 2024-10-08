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

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_employee');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_employee');
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

    public function transactions()
    {
        return $this->hasMany(EmployeeTransaction::class, 'employee_id', 'id');
    }

    public function deductions($update = false)
    {
        $amount = $this->transactions()->where('is_applied', false)->where('type', 'deduction')->sum('amount');
        if ($update) {
            $this->transactions()->where('is_applied', false)->where('type', 'deduction')->update([
                'is_applied' => true
            ]);
        }
        return $amount;
    }

    public function bonuses($update = false)
    {
        $amount = $this->transactions()->where('is_applied', false)->where('type', 'bonus')->sum('amount');
        if ($update) {
            $this->transactions()->where('is_applied', false)->where('type', 'bonus')->update([
                'is_applied' => true
            ]);
        }
        return $amount;
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
