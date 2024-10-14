<?php

namespace App\Http\Requests\Admin\Website;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class FooterRequest extends FormRequest
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
            'logo' => 'nullable|image',
            'emails' => 'required|array',
            'emails.*' => 'required_with:emails|email',
            'phone' => 'required|string',
            'whatsapp' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'x' => 'nullable|url',
            'be' => 'nullable|url',

            'location' => 'nullable|array',
            'location.en' => 'required_with:location|string',
            'location.de' => 'required_with:location|string',

            'subscription_paragraph' => 'nullable|array',
            'subscription_paragraph.en' => 'required_with:subscription_paragraph|string',
            'subscription_paragraph.de' => 'required_with:subscription_paragraph|string',

            'copyright' => 'required|array',
            'copyright.en' => 'required_with:copyright|string',
            'copyright.de' => 'required_with:copyright|string',
        ];
    }
}
