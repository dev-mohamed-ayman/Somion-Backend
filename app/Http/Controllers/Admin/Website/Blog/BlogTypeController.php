<?php

namespace App\Http\Controllers\Admin\Website\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogTypes = BlogType::query()
            ->select('id', 'name', 'show')
            ->order()
            ->get();

        return apiResponse(true, 200, $blogTypes);
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
            'show' => 'nullable|in:1,0'
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        $blogType = new BlogType();
        $blogType->name = $request->name;
        if ($request->show)
            $blogType->show = $request->show;
        $blogType->save();

        return apiResponse(true, 201, __('words.Successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blogType = BlogType::query()
            ->select('id', 'name', 'show')
            ->find($id);

        if (!$blogType) {
            return apiResponse(false, 404, __('words.Not found'));
        }

        return apiResponse(true, 200, $blogType);
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
            'show' => 'nullable|in:1,0'
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }


        $blogType = BlogType::query()->find($id);

        if (!$blogType) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        $blogType->name = $request->name;
        $blogType->show = $request->show ?? $blogType->show;
        $blogType->save();

        return apiResponse(true, 201, __('words.Successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blogType = BlogType::query()
            ->find($id);

        if (!$blogType) {
            return apiResponse(false, 404, __('words.Not found'));
        }

        $blogType->delete();

        return apiResponse(true, 204, __('words.Successfully deleted'));
    }

    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|array',
            'data.*' => 'required_with:data|exists:blog_types,id',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        foreach ($request->data as $key => $value) {
            $blogType = BlogType::query()->find($value);
            if ($blogType) {
                $blogType->order = $key + 1;
                $blogType->save();
            }
        }
        return apiResponse(true, 200, __('words.Successfully updated'));
    }
}
