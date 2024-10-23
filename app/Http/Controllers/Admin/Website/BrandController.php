<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brandSection = BrandSection::query()->select('title', 'updated_at as last_update')->first();
        $brands = Brand::query()->latest()->select('id', 'image')->get();
        return apiResponse(true, 200, [
            'brandSection' => $brandSection,
            'brands' => $brands,
        ]);
    }

    public function updateBrandSection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|array',
            'title.en' => 'required_with:title|string',
            'title.de' => 'required_with:title|string',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }
        $brandSection = BrandSection::first();
        $brandSection->title = $request->title;
        $brandSection->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }
        $brand = new Brand();
        $brand->image = uploadFile('brands', $request->image);
        $brand->save();
        return apiResponse(true, 201, __('words.Successfully created'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::query()->find($id);
        if (!$brand) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        deleteFile($brand->image);
        $brand->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
