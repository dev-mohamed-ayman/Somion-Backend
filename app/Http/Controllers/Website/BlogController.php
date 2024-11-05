<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogType;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function types()
    {
        $types = BlogType::query()->order()->get();
        return apiResponse(true, 200, $types);
    }

    public function metaTags()
    {
        return apiResponse(true, 200, [
            'meta_description' => ['en' => '123', 'de' => '123'],
            'meta_keywords' => ['en' => '123', 'de' => '123']
        ]);
    }

    public function blogs(Request $request)
    {
        $blogs = Blog::query()
            ->when($request->type, function ($type) use ($request) {
                $type->where('blog_type_id', $request->type);
            })
            ->when($request->sort === 'newest', function ($sort) use ($request) {
                $sort->latest();
            })
            ->when($request->sort === 'oldest', function ($sort) use ($request) {
                $sort->oldest();
            })
            ->when($request->sort === 'a-z', function ($sort) use ($request) {
                $sort->orderBy('title', 'asc');
            })
            ->order()->paginate(limit($request->limit));

        return apiResponse(true, 200, [
            'blogs' => $blogs->items(),
            'pagination' => pagination($blogs)
        ]);
    }

    public function index()
    {
        $latest = Blog::query()
            ->select('id', 'blog_type_id', 'title', 'description', 'image')
            ->order()->limit(5)->get();
        $blogs = BlogType::query()->order()->show()
            ->select('id', 'name')
            ->with(['blogs' => function ($blog) {
                $blog->select('id', 'blog_type_id', 'title', 'description', 'image');
            }])->get();

        return apiResponse(true, 200, [
            'latest' => $latest,
            'blogs' => $blogs,
            'meta_tags' => [
                'meta_description' => ['en' => '123', 'de' => '123'],
                'meta_keywords' => ['en' => '123', 'de' => '123']
            ],
        ]);
    }

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
}
