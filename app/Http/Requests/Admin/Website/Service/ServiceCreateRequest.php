<?php

namespace App\Http\Requests\Admin\Website\Service;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ServiceCreateRequest extends FormRequest
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

            'main_title' => 'required|array',
            'main_title.en' => 'required_with:main_title|string',
            'main_title.de' => 'required_with:main_title|string',

            'sub_title' => 'required|array',
            'sub_title.en' => 'required_with:sub_title|string',
            'sub_title.de' => 'required_with:sub_title|string',

            'short_description' => 'required|array',
            'short_description.en' => 'required_with:short_description|string',
            'short_description.de' => 'required_with:short_description|string',

            'description' => 'required|array',
            'description.en' => 'required_with:description|string',
            'description.de' => 'required_with:description|string',

            'service_category_id' => 'required|exists:service_categories,id',
            'image' => 'required|image',
            'main_image' => 'required|image',

        ];
    }
}
