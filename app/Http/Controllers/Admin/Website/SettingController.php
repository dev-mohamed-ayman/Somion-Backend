<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $data = HomeSetting::query()
            ->select('title', 'meta_description', 'meta_keywords')
            ->first();

        return apiResponse(true, 200, $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'array'],
            'title.en' => ['required_with:title', 'string', 'max:255'],
            'title.de' => ['required_with:title', 'string', 'max:255'],
            'meta_description' => ['nullable', 'array'],
            'meta_description.en' => ['required_with:meta_description', 'string', 'max:255'],
            'meta_description.de' => ['required_with:meta_description', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'array'],
            'meta_keywords.en' => ['required_with:meta_keywords', 'string', 'max:255'],
            'meta_keywords.de' => ['required_with:meta_keywords', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        $data = HomeSetting::query()->first();
        $data->title = $request->title;
        $data->meta_description = $request->meta_description;
        $data->meta_keywords = $request->meta_keywords;
        $data->save();

        return apiResponse(true, 200, __('words.Successfully updated'));
    }
}
