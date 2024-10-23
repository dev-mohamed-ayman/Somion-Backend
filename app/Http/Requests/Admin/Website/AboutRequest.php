<?php

namespace App\Http\Requests\Admin\Website;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AboutRequest extends FormRequest
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

            'sub_title' => 'required|array',
            'sub_title.en' => 'required_with:sub_title|string',
            'sub_title.de' => 'required_with:sub_title|string',

            'description' => 'required|array',
            'description.en' => 'required_with:description|string',
            'description.de' => 'required_with:description|string',

            'last_title' => 'required|array',
            'last_title.en' => 'required_with:last_title|array|between:1,3',
            'last_title.de' => 'required_with:last_title|array|between:1,3',
            'last_title.de.*' => 'required_with:last_title.de|string',
            'last_title.en.*' => 'required_with:last_title.en|string',

            'items' => 'required|array',
            'items.en' => 'required_with:items|array|min:1',
            'items.de' => 'required_with:items|array|min:1',
            'items.en.*' => 'required_with:items.en|array',
            'items.de.*' => 'required_with:items.de|array',
            'items.en.*.title' => 'required_with:items.en.*|string',
            'items.de.*.title' => 'required_with:items.de.*|string',
            'items.de.*.description' => 'required_with:items.de.*|string',
            'items.en.*.description' => 'required_with:items.en.*|string',

            'our_mission' => 'required|array',
            'our_mission.en' => 'required_with:our_mission|string',
            'our_mission.de' => 'required_with:our_mission|string',

        ];
    }
}
