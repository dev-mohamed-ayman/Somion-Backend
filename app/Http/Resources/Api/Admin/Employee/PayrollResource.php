<?php

namespace App\Http\Resources\Api\Admin\Employee;

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
        return [
            'id' => $this->id,
            'employee_name' => $this->employee->user->name,
            'employee_image' => $this->employee->user->image,
            'employee_phone' => $this->employee->user->phone,
            'base_salary' => $this->base_salary,
            'total_loans' => $this->total_loans,
            'total_deductions' => $this->total_deductions,
            'total_bonuses' => $this->total_bonuses,
            'salary' => $this->salary,
            'is_paid' => $this->is_paid ? true : false,
            'payment_date' => $this->is_paid ? $this->payment_date : null,
        ];
    }
}
