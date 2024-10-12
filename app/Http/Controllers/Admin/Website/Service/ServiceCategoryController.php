<?php

namespace App\Http\Controllers\Admin\Website\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\Service\CategoryCreateRequest;
use App\Http\Resources\Api\Admin\Website\Service\ServiceCategoryResource;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceCategories = ServiceCategory::query()->latest()->get();
        return apiResponse(true, 200, ServiceCategoryResource::collection($serviceCategories));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request)
    {
        $serviceCategory = new ServiceCategory();
        $serviceCategory->title = $request->title;
        $serviceCategory->main_title = $request->main_title;
        $serviceCategory->save();
        return apiResponse(true, 201, __('words.Successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $serviceCategory = ServiceCategory::query()->find($id);
        if (!$serviceCategory) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        return apiResponse(true, 200, new ServiceCategoryResource($serviceCategory));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryCreateRequest $request, string $id)
    {
        $serviceCategory = ServiceCategory::query()->find($id);
        if (!$serviceCategory) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        $serviceCategory->title = $request->title;
        $serviceCategory->main_title = $request->main_title;
        $serviceCategory->save();

        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $serviceCategory = ServiceCategory::query()->find($id);
        if ($serviceCategory->services()->count() > 0) {
            return apiResponse(false, 400, __('words.Cannot delete category with associated services'));
        }
        if (!$serviceCategory) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        $serviceCategory->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
