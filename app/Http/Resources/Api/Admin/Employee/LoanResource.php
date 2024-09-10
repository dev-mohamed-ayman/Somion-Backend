<?php

namespace App\Http\Resources\Api\Admin\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'total_amount' => $this->total_amount,
            'remaining_amount' => $this->remaining_amount,
            'installments_count' => $this->installments_count,
            'installments_paid' => $this->installments_paid,
            'installments_unpaid' => $this->installments_count - $this->installments_paid,
            'start_date' => $this->start_date,
        ];
    }
}
