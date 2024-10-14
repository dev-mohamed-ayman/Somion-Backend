<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use App\Models\RateSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rateSection = RateSection::query()
            ->select('title', 'sub_title', 'paragraph', 'updated_at as last_update')
            ->latest()->first();
        $rates = Rate::query()->active()->latest()->get();

        return apiResponse(true, 200, [
            'rateSection' => $rateSection,
            'rates' => $rates
        ]);
    }

    public function updateRateSection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|array',
            'title.en' => 'required_with:title|string',
            'title.de' => 'required_with:title|string',
            '_sub_title' => 'required|array',
            '_sub_title.en' => 'required_with:_sub_title|string',
            '_sub_title.de' => 'required_with:_sub_title|string',
            'paragraph' => 'required|array',
            'paragraph.en' => 'required_with:paragraph|string',
            'paragraph.de' => 'required_with:paragraph|string',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }
        $rateSection = RateSection::query()->first();
        $rateSection->title = $request->title;
        $rateSection->sub_title = $request->_sub_title;
        $rateSection->paragraph = $request->paragraph;
        $rateSection->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'image' => 'nullable|image',
            'message' => 'nullable|max:500',
            'rate' => 'required|gte:0|lte:5',
            'status' => 'nullable|in:1,0',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }
        $rate = new Rate();
        $rate->first_name = $request->first_name;
        $rate->last_name = $request->last_name;
        if ($request->image)
            $rate->image = uploadFile('rates', $request->image);
        $rate->message = $request->message;
        $rate->rate = $request->rate;
        $rate->status = $request->status;
        $rate->save();
        return apiResponse(true, 201, __('words.Successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rate = Rate::query()->find($id);
        if (!$rate)
            return apiResponse(false, 404, __('words.Not found'));
        return apiResponse(true, 200, $rate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'image' => 'nullable|image',
            'message' => 'nullable|max:500',
            'rate' => 'required|gte:0|lte:5',
            'status' => 'nullable|in:1,0',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }
        $rate = Rate::query()->find($id);
        if (!$rate) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        $rate->first_name = $request->first_name;
        $rate->last_name = $request->last_name;
        if ($request->image) {
            deleteFile($rate->image);
            $rate->image = uploadFile('rates', $request->image);
        }
        $rate->message = $request->message;
        $rate->rate = $request->rate;
        $rate->status = $request->status;
        $rate->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rate = Rate::query()->find($id);
        if (!$rate) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        deleteFile($rate->image);
        $rate->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
