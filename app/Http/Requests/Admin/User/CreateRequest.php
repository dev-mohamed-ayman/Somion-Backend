<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateRequest extends FormRequest
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
            'phone' => 'nullable|unique:users,phone',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'status' => 'required|string|in:active,inactive',
            'image' => 'nullable|file',
            'roles' => 'required|array',
            'roles.*' => 'required_with:roles|exists:roles,name',
            'password' => 'required|string|confirmed',
        ];
    }
}
