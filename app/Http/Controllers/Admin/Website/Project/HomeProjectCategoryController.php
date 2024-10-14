<?php

namespace App\Http\Controllers\Admin\Website\Project;

use App\Http\Controllers\Controller;
use App\Models\HomeProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = HomeProjectCategory::query()
            ->select('id', 'name')
            ->withCount('projects')
            ->get();

        return apiResponse(true, 200, $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|array',
            'name.en' => 'required_with:name|string',
            'name.de' => 'required_with:name|string',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 400, $validator->messages()->all());
        }
        $category = new HomeProjectCategory();
        $category->name = $request->name;
        $category->save();
        return apiResponse(true, 201, __('words.Successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = HomeProjectCategory::query()->select('id', 'name')->findOr($id, function () {
            return apiResponse(false, 404, __('words.Not found'));
        });
        return apiResponse(true, 200, $category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|array',
            'name.en' => 'required_with:name|string',
            'name.de' => 'required_with:name|string',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 400, $validator->messages()->all());
        }
        $category = HomeProjectCategory::query()->findOr($id, function () {
            return apiResponse(false, 404, __('words.Not found'));
        });
        $category->name = $request->name;
        $category->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = HomeProjectCategory::query()->findOr($id, function () {
            return apiResponse(false, 404, __('words.Not found'));
        });
        $category->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
