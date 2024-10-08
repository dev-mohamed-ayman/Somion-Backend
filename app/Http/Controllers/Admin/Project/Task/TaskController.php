<?php

namespace App\Http\Controllers\Admin\Project\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Project\Task\TaskOrderRequest;
use App\Http\Requests\Admin\Project\UpdateTaskRequest;
use App\Http\Resources\Api\Admin\Project\Task\TaskResource;
use App\Http\Resources\Api\Admin\Project\Task\TasksResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    public function index($section_id)
    {
        $tasks = Task::query()
            ->where('section_id', $section_id)
            ->orderBy('order', 'asc')
            ->get();
        return apiResponse(true, 200, TasksResource::collection($tasks));
    }

    public function show($task_id)
    {
        $task = Task::query()->findOr($task_id, function () {
            return apiResponse(false, 404, __('words.Task not found'));
        });
        return apiResponse(true, 200, new TaskResource($task));
    }

    public function employees($project_id)
    {
        $project = Project::query()->findOr($project_id, function () {
            return apiResponse(false, 404, __('words.Project not found'));
        });
        $employees = $project->employees()->with('user')->latest()->get()->map(function ($employee) {
            return [
                'id' => $employee->id,
                'name' => $employee->user->name,
                'image' => $employee->user->image
            ];
        });

        return apiResponse(true, 200, $employees);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string'
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        $task = new Task();
        $task->section_id = $request->section_id;
        $task->title = $request->title;
        $task->save();

        return apiResponse(true, 200, __('words.Successfully created'));
    }

    public function update(UpdateTaskRequest $request)
    {
        DB::beginTransaction();
        try {

            $task = Task::query()->findOr($request->task_id, function () {
                return apiResponse(false, 404, __('words.Task not found'));
            });

            if ($request->section_id)
                $task->section_id = $request->section_id;
            if ($request->title)
                $task->title = $request->title;
            if ($request->description)
                $task->description = $request->description;
            if ($request->start_date)
                $task->start_date = $request->start_date;
            if ($request->end_date)
                $task->end_date = $request->end_date;
            $task->save();

            if ($request->employees) {
                $task->employees()->sync($request->employees);
            }


            DB::commit();
            return apiResponse(true, 200, __('words.Successfully updated'));
        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, 500, $e->getMessage());
        }
    }

    public function order(Request $request)
    {
        foreach ($request->data as $section => $tasks) {
            foreach ($tasks as $order => $task) {
                Task::query()->where('id', $task)->update([
                    'order' => $order,
                    'section_id' => $section,
                ]);
            }
        }

        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    public function delete(Task $task)
    {
        foreach ($task->comments as $comment) {
            foreach ($comment->files as $file) {
                deleteFile($file->path);
            }
        }
        $task->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
