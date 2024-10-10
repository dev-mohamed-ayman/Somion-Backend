<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Project\ProjectCreateRequest;
use App\Http\Requests\Admin\Project\ProjectUpdateRequest;
use App\Http\Requests\Admin\Project\ProjectupdateStatusAndOrderRequest;
use App\Http\Resources\Api\Admin\Project\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::query()
            ->orderBy('order', 'desc')
            ->with(['users', 'employees', 'client'])
            ->paginate(limit($request->limit));
        return apiResponse(true, 200, ProjectResource::collection($projects));
    }

    public function show(Project $project)
    {
        return apiResponse(true, 200, new ProjectResource($project));
    }

    public function create(ProjectCreateRequest $request)
    {
        DB::beginTransaction();
        try {

            $project = new Project();
            $project->name = $request->name;
            $project->description = $request->description;
            $project->notes = $request->notes;
            $project->client_id = $request->client_id;
            $project->start_date = $request->start_date;
            $project->end_date = $request->end_date;
            $project->bg_image = $request->bg_image;
            $project->bg_color = $request->bg_color;
            if ($request->currency)
                $project->currency = $request->currency;
            $project->total_amount = $request->total_amount;
            if ($request->priority)
                $project->priority = $request->priority;
            $project->save();

            if ($request->users)
                $project->users()->attach($request->users);

            if ($request->employees)
                $project->employees()->attach($request->employees);

            DB::commit();
            return apiResponse(true, 201, __('words.Successfully created'));
        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, 500, $e->getMessage());
        }
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        DB::beginTransaction();
        try {

            $project->name = $request->name;
            $project->description = $request->description;
            $project->notes = $request->notes;
            $project->client_id = $request->client_id;
            $project->start_date = $request->start_date;
            $project->end_date = $request->end_date;
            $project->bg_image = $request->bg_image;
            $project->bg_color = $request->bg_color;
            if ($request->currency)
                $project->currency = $request->currency;
            $project->total_amount = $request->total_amount;
            if ($request->priority)
                $project->priority = $request->priority;
            $project->save();

            if ($request->users)
                $project->users()->sync($request->users);

            if ($request->employees)
                $project->employees()->sync($request->employees);

            DB::commit();
            return apiResponse(true, 200, __('words.Successfully updated'));
        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, 500, $e->getMessage());
        }
    }

    public function destroy(Project $project)
    {
        deleteFile($project->bg_image);
        $project->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }

    public function users()
    {
        $users = User::query()->select('id', 'name', 'image')->get();
        return apiResponse(true, 200, $users);
    }

    public function employees()
    {
        $employees = User::query()->where('type', 'employee')->select('id', 'name', 'image')->get();
        return apiResponse(true, 200, $employees);
    }

    public function updateStatusAndOrder(Request $request)
    {
        DB::beginTransaction();

        try {
            foreach ($request->data as $status => $projects) {
                foreach ($projects as $order => $project) {
                    Project::where('id', $project['id'])
                        ->update([
                            'project_status' => $status,
                            'order' => $project['order']
                        ]);
                }
            }

            DB::commit();
            return apiResponse(true, 200, __('words.Successfully updated'));
        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, 500, __('words error occurred'), null, $e->getMessage());
        }
    }
}
