<?php

namespace App\Http\Controllers\Admin\Website\Service;

use App\Http\Controllers\Controller;
use App\Models\ServiceFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $features = ServiceFeature::query()
            ->when($request->service_id, function ($q) use ($request) {
                $q->where('service_id', $request->service_id);
            })
            ->select('id', 'image', 'title', 'description')
            ->latest()
            ->get();
        return apiResponse(true, 200, $features);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'title' => 'required|array',
            'title.en' => 'required_with:title|string|max:255',
            'title.de' => 'required_with:title|string|max:255',
            'description' => 'required|array',
            'description.en' => 'required_with:description|string',
            'description.de' => 'required_with:description|string',
            'service_id' => 'required|exists:services,id',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }
        $feature = new ServiceFeature();
        $feature->image = uploadFile('services/features', $request->image);
        $feature->title = $request->title;
        $feature->description = $request->description;
        $feature->service_id = $request->service_id;
        $feature->save();

        return apiResponse(true, 201, __('words.Successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $feature = ServiceFeature::query()
            ->select('id', 'image', 'title', 'description')
            ->find($id);
        if (!$feature) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        return apiResponse(true, 200, $feature);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'title' => 'required|array',
            'title.en' => 'required_with:title|string|max:255',
            'title.de' => 'required_with:title|string|max:255',
            'description' => 'required|array',
            'description.en' => 'required_with:description|string',
            'description.de' => 'required_with:description|string',
            'service_id' => 'required|exists:services,id',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        $feature = ServiceFeature::query()
            ->select('id', 'image', 'title', 'description')
            ->find($id);
        if (!$feature) {
            return apiResponse(false, 404, __('words.Not found'));
        }

        if ($request->image) {
            deleteFile($feature->image);
            $feature->image = uploadFile('services/features', $request->image);
        }
        $feature->title = $request->title;
        $feature->description = $request->description;
        $feature->service_id = $request->service_id;
        $feature->save();

        return apiResponse(true, 201, __('words.Successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $feature = ServiceFeature::find($id);
        if (!$feature) {
            return apiResponse(false, 404, __('words.Not found'));
        }

        deleteFile($feature->image);
        $feature->delete();

        return apiResponse(true, 204, __('words.Successfully deleted'));
    }
}
