<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Why;
use App\Models\WhySection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WhyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $whySection = WhySection::query()->select('title', 'updated_at as last_updated')->first();
        $whies = Why::query()->select('id', 'title', 'description')->latest()->get();
        return apiResponse(true, 200, [
            'whySection' => $whySection,
            'whies' => $whies,
        ]);
    }

    public function updateWhySection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|array',
            'title.en' => 'required_with:title|string',
            'title.de' => 'required_with:title|string',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }
        $whySection = WhySection::query()->first();
        $whySection->title = $request->title;
        $whySection->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
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
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }
        $why = new Why();
        $why->title = $request->title;
        $why->description = $request->description;
        $why->save();
        return apiResponse(true, 201, __('words.Successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $why = Why::query()->find($id);
        if ($why === null) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        return apiResponse(true, 200, $why);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|array',
            'title.en' => 'required_with:title|string',
            'title.de' => 'required_with:title|string',
            'description' => 'required|array',
            'description.en' => 'required_with:description|string',
            'description.de' => 'required_with:description|string',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }
        $why = Why::query()->find($id);
        if ($why === null) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        $why->title = $request->title;
        $why->description = $request->description;
        $why->save();

        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $why = Why::query()->find($id);
        if ($why === null) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        $why->delete();
        return apiResponse(true, 204, __('words.Successfully deleted'));
    }
}
