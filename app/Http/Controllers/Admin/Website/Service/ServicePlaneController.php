<?php

namespace App\Http\Controllers\Admin\Website\Service;

use App\Http\Controllers\Controller;
use App\Models\ServicePlane;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicePlaneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $planes = ServicePlane::query()
            ->when($request->service_id, function ($q) use ($request) {
                $q->where('service_id', $request->service_id);
            })
            ->select('id', 'title', 'include')
            ->latest()
            ->get();

        return apiResponse(true, 200, $planes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',

            'title' => 'required|array',
            'title.en' => 'required_with:title|string|max:255',
            'title.de' => 'required_with:title|string|max:255',

            'include' => 'nullable|array',
            'include.en' => 'required_with:include|array',
            'include.de' => 'required_with:include|array',
            'include.en.*' => 'required_with:include.en|string|max:255',
            'include.de.*' => 'required_with:include.de|string|max:255',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        $plane = new ServicePlane();
        $plane->service_id = $request->service_id;
        $plane->title = $request->title;
        $plane->include = $request->include;
        $plane->save();

        return apiResponse(true, 201, __('words.Successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plane = ServicePlane::query()
            ->select('id', 'title', 'include')
            ->find($id);
        if (!$plane) {
            return apiResponse(false, 404, __('words.Not found'));
        }

        return apiResponse(true, 200, $plane);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',

            'title' => 'required|array',
            'title.en' => 'required_with:title|string|max:255',
            'title.de' => 'required_with:title|string|max:255',

            'include' => 'nullable|array',
            'include.en' => 'required_with:include|array',
            'include.de' => 'required_with:include|array',
            'include.en.*' => 'required_with:include.en|string|max:255',
            'include.de.*' => 'required_with:include.de|string|max:255',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        $plane = ServicePlane::find($id);
        if (!$plane) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        $plane->service_id = $request->service_id;
        $plane->title = $request->title;
        $plane->include = $request->include;
        $plane->save();

        return apiResponse(true, 201, __('words.Successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plane = ServicePlane::find($id);
        if (!$plane) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        $plane->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
