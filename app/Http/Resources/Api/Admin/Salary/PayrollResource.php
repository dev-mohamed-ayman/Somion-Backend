<?php

namespace App\Http\Resources\Api\Admin\Salary;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayrollResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // حساب الخصومات، السلف والمكافآت للموظف
        $totalLoans = $this->employee->loans->sum('remaining_amount');
        $totalDeductions = $this->employee->deductions->sum('amount');
        $totalBonuses = $this->employee->bonuses->sum('amount');
        $netSalary = $this->salary - $totalLoans - $totalDeductions + $totalBonuses;
        return [
            'payroll_id' => $this->id,
            'employee_name' => $this->employee->user->name,
            'base_salary' => $this->salary,
            'total_loans' => $totalLoans,
            'total_deductions' => $totalDeductions,
            'total_bonuses' => $totalBonuses,
            'net_salary' => $netSalary,
            'is_paid' => $this->is_paid ? __('words.Paid') : __('words.Unpaid'),
            'payment_date' => $this->payment_date->format('d-m-Y'),
        ];
    }
}
