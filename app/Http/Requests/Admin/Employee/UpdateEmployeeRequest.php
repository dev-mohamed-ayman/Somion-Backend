<?php

namespace App\Http\Requests\Admin\Employee;

use App\Models\Employee;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateEmployeeRequest extends FormRequest
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
            'name' => 'required|string|min:2',
            'phone' => 'nullable',
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|string|confirmed',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
            'employee_job_id' => 'required|exists:employee_jobs,id',
            'employment_status_id' => 'required|exists:employment_statuses,id',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'joining_date' => 'required|date',
            'salary' => 'required',
            'payment_information' => 'required|string',
        ];
    }
}
