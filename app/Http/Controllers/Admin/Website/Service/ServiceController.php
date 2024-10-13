<?php

namespace App\Http\Controllers\Admin\Website\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\Service\ServiceCreateRequest;
use App\Http\Requests\Admin\Website\Service\ServiceUpdateRequest;
use App\Http\Resources\Api\Admin\Website\Service\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $services = Service::query()->latest()->paginate(limit($request->limit));
        return apiResponse(true, 200, ServiceResource::collection($services));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceCreateRequest $request)
    {
        $service = new Service();
        $service->title = $request->title;
        $service->main_title = $request->main_title;
        $service->sub_title = $request->sub_title;
        $service->short_description = $request->short_description;
        $service->description = $request->description;
        $service->service_category_id = $request->service_category_id;
        $service->image = uploadFile('services', $request->image);
        $service->main_image = uploadFile('services', $request->main_image);
        $service->save();

        return apiResponse(true, 201, __('words.Successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        return apiResponse(true, 200, new ServiceResource($service));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceUpdateRequest $request, string $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return apiResponse(false, 404, __('words.Not found'));
        }

        $service->title = $request->title;
        $service->main_title = $request->main_title;
        $service->sub_title = $request->sub_title;
        $service->short_description = $request->short_description;
        $service->description = $request->description;
        $service->service_category_id = $request->service_category_id;
        if ($request->image) {
            deleteFile($service->image);
            $service->image = uploadFile('services', $request->image);
        }
        if ($request->main_image) {
            deleteFile($service->main_image);
            $service->main_image = uploadFile('services', $request->main_image);
        }
        $service->save();

        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return apiResponse(false, 404, __('words.Not found'));
        }

        deleteFile($service->image);
        deleteFile($service->main_image);
        $service->delete();

        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
