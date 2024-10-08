<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
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
            'id' => 'required|exists:users,id',
            'name' => 'required|string|min:2',
            'phone' => 'nullable|unique:users,phone,' . $this->id,
            'username' => 'required|string|unique:users,username,' . $this->id,
            'email' => 'required|email|unique:users,email,' . $this->id,
            'status' => 'required|string|in:active,inactive',
            'image' => 'nullable|file',
            'roles' => 'required|array',
            'roles.*' => 'required_with:roles|exists:roles,name',
            'password' => 'nullable|string|confirmed',
        ];
    }
}
