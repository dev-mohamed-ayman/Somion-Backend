<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\AboutRequest;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = About::query()->select(
            'title',
            'sub_title',
            'description',
            'last_title',
            'items',
            'our_mission',
            'updated_at as last_update'
        )->first();
        return apiResponse(true, 200, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutRequest $request)
    {
        $about = About::query()->first();
        $about->title = $request->title;
        $about->sub_title = $request->sub_title;
        $about->description = $request->description;
        $about->last_title = $request->last_title;
        $about->items = $request->items;
        $about->our_mission = $request->our_mission;
        $about->save();

        return apiResponse(true, 200, __('words.Successfully updated'));
    }

}
