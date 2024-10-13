<?php

namespace App\Http\Controllers\Admin\Website\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\Project\HomeProjectSectionRequest;
use App\Models\HomeProjectSection;
use Illuminate\Http\Request;

class HomeProjectSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeProjectSection = HomeProjectSection::query()
            ->select('title', 'description', 'sub_title', 'updated_at as last_update')
            ->first();

        return apiResponse(true, 200, $homeProjectSection);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HomeProjectSectionRequest $request)
    {
        $homeProjectSection = HomeProjectSection::first();
        $homeProjectSection->title = $request->title;
        $homeProjectSection->description = $request->description;
        $homeProjectSection->sub_title = $request->sub_title;
        $homeProjectSection->save();
        return apiResponse(true, 200, __('words.Successfully created'));
    }
}
