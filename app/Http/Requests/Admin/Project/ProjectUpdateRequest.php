<?php

namespace App\Http\Requests\Admin\Project;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ProjectUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'currency' => 'nullable|string',
            'total_amount' => 'nullable',
            'priority' => 'nullable|string|in:low,medium,high',
            'users' => 'nullable|array',
            'users.*' => 'required_with:users|exists:users,id',
            'employees' => 'nullable|array',
            'employees.*' => 'required_with:employees|exists:employees,id',
        ];
    }
}
