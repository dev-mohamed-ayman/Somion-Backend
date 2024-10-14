<?php

namespace App\Http\Controllers\Admin\Website\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\Project\HomeProjectCreateRequest;
use App\Http\Requests\Admin\Website\Project\HomeProjectUpdateRequest;
use App\Http\Resources\Api\Admin\Website\PRoject\HomeProjectResource;
use App\Models\HomeProject;
use App\Models\HomeProjectImage;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = HomeProject::query()->latest()->with('images', 'categories')->get();
        return apiResponse(true, 200, HomeProjectResource::collection($projects));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HomeProjectCreateRequest $request)
    {
        DB::beginTransaction();
        try {

            $project = new HomeProject();
            $project->title = $request->title;
            $project->description = $request->description;
            $project->link = $request->link;
            $project->save();

            $project->categories()->attach($request->categories);

            foreach ($request->images as $i) {
                $image = new HomeProjectImage();
                $image->home_project_id = $project->id;
                $image->path = uploadFile('home_project', $i);
                $image->save();
            }

            DB::commit();
            return apiResponse(true, 201, __('words.Successfully created'));

        } catch (\Exception $exception) {
            DB::rollBack();
            return apiResponse(false, 500, $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = HomeProject::query()->find($id);
        if (!$project) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        return apiResponse(true, 200, new HomeProjectResource($project));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HomeProjectUpdateRequest $request, string $id)
    {
        DB::beginTransaction();
        try {

            $project = HomeProject::query()->findOr($id, function () {
                return apiResponse(false, 404, __('words.Not found'));
            });
            $project->title = $request->title;
            $project->description = $request->description;
            $project->link = $request->link;
            $project->save();

            foreach ($request->images as $i) {
                $image = new HomeProjectImage();
                $image->home_project_id = $project->id;
                $image->path = uploadFile('home_project', $i);
                $image->save();
            }

            DB::commit();
            return apiResponse(true, 201, __('words.Successfully created'));

        } catch (\Exception $exception) {
            DB::rollBack();
            return apiResponse(false, 500, $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {

            $project = HomeProject::query()->findOr($id);
            if (!$project) {
                return apiResponse(false, 404, __('words.Not found'));
            }

            $images = $project->images;


            foreach ($images as $image) {
                deleteFile($image->path);
                $image->delete();
            }

            $project->categories()->detach();

            $project->delete();
            DB::commit();
            return apiResponse(true, 204, __('words.Successfully deleted'));

        } catch (\Exception $exception) {
            DB::rollBack();
            return apiResponse(false, 500, $exception->getMessage());
        }
    }
}
