<?php

namespace App\Http\Resources\Api\Admin\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'employee_id' => $this->employee_id,
            'employee_name' => $this->employee->user->name,
            'employee_image' => $this->employee->user->image,
            'amount' => $this->amount,
            'type' => $this->type,
            'reason' => $this->reason,
            'date' => $this->created_at,
            'is_applied' => $this->is_applied ? true : false,
        ];
    }
}
