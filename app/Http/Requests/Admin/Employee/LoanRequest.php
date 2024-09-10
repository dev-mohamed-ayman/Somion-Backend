<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
        {
            $response = apiResponse(false, 422, $validator->messages()->all());

            throw new ValidationException($validator, $response);
        }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'total_amount' => 'required',
            'installments_count' => 'required',
            'start_date' => 'required|date',
        ];
    }
}
