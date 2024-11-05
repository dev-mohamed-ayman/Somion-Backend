<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Imprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImprintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imprint = Imprint::query()->select(
            'title',
            'body',
            'meta_description',
            'meta_keywords',
            'updated_at as last_update'
        )->first();
        return apiResponse(true, 200, $imprint);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|array',
            'title.en' => 'required_with:title|string',
            'title.de' => 'required_with:title|string',
            'body' => 'required|array',
            'body.en' => 'required_with:body|string',
            'body.de' => 'required_with:body|string',
            'meta_description' => 'nullable|array',
            'meta_description.en' => 'required_with:meta_description|string',
            'meta_description.de' => 'required_with:meta_description|string',
            'meta_keywords' => 'nullable|array',
            'meta_keywords.en' => 'required_with:meta_keywords|string',
            'meta_keywords.de' => 'required_with:meta_keywords|string',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 400, $validator->messages()->all());
        }
        $imprint = Imprint::first();
        $imprint->title = $request->title;
        $imprint->body = $request->body;
        $imprint->meta_description = $request->meta_description;
        $imprint->meta_keywords = $request->meta_keywords;
        $imprint->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }
}
