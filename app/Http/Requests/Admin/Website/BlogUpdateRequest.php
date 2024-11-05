<?php

namespace App\Http\Requests\Admin\Website;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BlogUpdateRequest extends FormRequest
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
            'blog_type_id' => 'required|exists:blog_types,id',

            'title' => 'required|array',
            'title.en' => 'required_with:title|string',
            'title.de' => 'required_with:title|string',

            'description' => 'required|array',
            'description.en' => 'required_with:description|string',
            'description.de' => 'required_with:description|string',

            'body' => 'required|array',
            'body.en' => 'required_with:body|string',
            'body.de' => 'required_with:body|string',

            'image' => 'nullable|array',
            'image.en' => 'required_with:image|image',
            'image.de' => 'required_with:image|image',

            'meta_description' => 'nullable|array',
            'meta_description.en' => 'required_with:meta_description|string',
            'meta_description.de' => 'required_with:meta_description|string',

            'meta_tags' => 'nullable|array',
            'meta_tags.en' => 'required_with:meta_tags|string',
            'meta_tags.de' => 'required_with:meta_tags|string',
        ];
    }
}
