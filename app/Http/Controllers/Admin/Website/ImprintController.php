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
        $imprint = Imprint::query()->select('title', 'body', 'updated_at as last_update')->first();
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
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 400, $validator->messages()->all());
        }
        $imprint = Imprint::first();
        $imprint->title = $request->title;
        $imprint->body = $request->body;
        $imprint->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }
}
