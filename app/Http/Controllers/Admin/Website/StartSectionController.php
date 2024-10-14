<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\StartSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StartSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $startSection = StartSection::query()->select('title', 'description', 'btn_title', 'updated_at as last_update')->first();
        return apiResponse(true, 200, $startSection);
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
            'description' => 'required|array',
            'description.en' => 'required_with:description|string',
            'description.de' => 'required_with:description|string',
            'brn_title' => 'required|array',
            'brn_title.en' => 'required_with:brn_title|string',
            'brn_title.de' => 'required_with:brn_title|string',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }
        $startSection = StartSection::first();
        $startSection->title = $request->title;
        $startSection->description = $request->description;
        $startSection->btn_title = $request->brn_title;
        $startSection->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }
}
