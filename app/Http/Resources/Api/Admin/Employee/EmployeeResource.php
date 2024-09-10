<?php

namespace App\Http\Resources\Api\Admin\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'name' => $this->user->name,
            'email' => $this->user->email,
            'username' => $this->user->username,
            'phone' => $this->user->phone,
            'image' => $this->user->image,
            'employeeJob' => $this->employeeJob->getTranslations('title'),
            'employmentStatus' => $this->employmentStatus->getTranslations('title'),
            'employee_job_id' => $this->employee_job_id,
            'employment_status_id' => $this->employment_status_id,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'address' => $this->address,
            'joining_date' => $this->joining_date,
            'salary' => $this->salary,
            'payment_information' => $this->payment_information,
        ];
    }
}
