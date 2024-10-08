<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LeaveRequestRequest extends FormRequest
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
            'type' => 'required|in:days,hours',
            'start_date' => 'required|date',
            'end_date' => 'required_if:type,days|date|after_or_equal:start_date',
            'start_time' => 'required_if:type,hours|date_format:H:i',
            'end_time' => 'required_if:type,hours|date_format:H:i|after:start_time',
            'reason' => 'nullable|string',
        ];
    }
}
