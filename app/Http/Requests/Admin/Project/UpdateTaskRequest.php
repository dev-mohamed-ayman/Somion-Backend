<?php

namespace App\Http\Requests\Admin\Project;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateTaskRequest extends FormRequest
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
            'task_id' => 'required|exists:tasks,id',
            'section_id' => 'nullable|exists:sections,id',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date|string',
            'end_date' => 'nullable|date|string',
            'employees' => 'nullable|array',
            'employees.*' => 'required_with:employees|exists:employees,id',
            'bg_color' => 'nullable|string',
        ];
    }
}
