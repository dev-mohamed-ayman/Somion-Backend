<?php

namespace App\Http\Requests\Admin\Website;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class HeroRequest extends FormRequest
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
            'title' => 'required|string',
            'short_description' => 'required|string',
            'btn_title' => 'required|string',
            'items' => 'nullable|array',
            'items.*' => 'required_with:items|array',
            'items.*.id' => 'required_with:items.*|exists:hero_items,id',
            'items.*.icon' => 'required_with:items.*|file',
            'items.*.number' => 'required_with:items.*|string',
            'items.*.title' => 'required_with:items.*|title',
        ];
    }
}
