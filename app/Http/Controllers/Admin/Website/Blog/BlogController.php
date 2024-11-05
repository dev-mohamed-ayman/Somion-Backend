<?php

namespace App\Http\Controllers\Admin\Website\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\BlogCreateRequest;
use App\Http\Requests\Admin\Website\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\BlogType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $blogs = Blog::query()
            ->select('id', 'title', 'description', 'image')
            ->order()
            ->paginate(limit($request->limit));

        return apiResponse(true, 200, [
            'blogs' => $blogs->items(),
            'pagination' => pagination($blogs)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCreateRequest $request)
    {
        $blog = new Blog();
        $blog->blog_type_id = $request->blog_type_id;
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->body = $request->body;
        $blog->image = [
            'de' => uploadFile('blogs', $request->image['de']),
            'en' => uploadFile('blogs', $request->image['en']),
        ];
        if ($request->meta_description)
            $blog->meta_description = $request->meta_description;
        if ($request->meta_tags)
            $blog->meta_tags = $request->meta_tags;
        $blog->save();
        return apiResponse(true, 201, __('words.Successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::query()
            ->with('type')
            ->find($id);

        if (!$blog) {
            return apiResponse(false, 404, $blog);
        }

        return apiResponse(true, 200, $blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, string $id)
    {
        $blog = Blog::query()
            ->find($id);

        if (!$blog) {
            return apiResponse(false, 404, __('words.Not found'));
        }

        $blog->blog_type_id = $request->blog_type_id;
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->body = $request->body;
        if ($request->image) {
            deleteFile($blog->getTranslation('image', 'en'));
            deleteFile($blog->getTranslation('image', 'en'));
            $blog->image = [
                'en' => uploadFile('blogs', $request->image['en']),
                'de' => uploadFile('blogs', $request->image['de']),
            ];
        }
        $blog->meta_description = $request->meta_description;
        $blog->meta_tags = $request->meta_tags;
        $blog->save();

        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::query()
            ->find($id);

        if (!$blog) {
            return apiResponse(false, 404, __('words.Not found'));
        }

        deleteFile($blog->getTranslation('image', 'en'));
        deleteFile($blog->getTranslation('image', 'de'));

        $blog->delete();

        return apiResponse(true, 200, __('words.Successfully deleted'));
    }

    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|array',
            'data.*' => 'required_with:data|exists:blogs,id',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        foreach ($request->data as $key => $value) {
            $blog = Blog::query()->find($value);
            if ($blog) {
                $blog->order = $key + 1;
                $blog->save();
            }
        }
        return apiResponse(true, 200, __('words.Successfully updated'));
    }
}
