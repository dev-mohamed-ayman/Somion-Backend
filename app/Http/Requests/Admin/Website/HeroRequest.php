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
            'title' => 'required|array',
            'title.en' => 'required_with:title|string',
            'title.de' => 'required_with:title|string',

            'short_description' => 'required|array',
            'short_description.en' => 'required_with:short_description|string',
            'short_description.de' => 'required_with:short_description|string',

            'btn_title' => 'required|array',
            'btn_title.en' => 'required_with:btn_title|string',
            'btn_title.de' => 'required_with:btn_title|string',

            'items' => 'nullable|array',
            'items.*' => 'required_with:items|array',
            'items.*.id' => 'required_with:items.*|exists:hero_items,id',
            'items.*.number' => 'required_with:items.*|string',
            'items.*.title' => 'required_with:items.*|array',
            'items.*.title.en' => 'required_with:items.*.title|string',
            'items.*.title.de' => 'required_with:items.*.title|string',
        ];
    }
}
