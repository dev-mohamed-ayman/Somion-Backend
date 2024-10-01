<?php

namespace App\Http\Controllers\Admin\Project\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Project\UpdateTaskRequest;
use App\Http\Resources\Api\Admin\Project\Task\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    public function index($section_id)
    {
        return 123;
        $tasks = Task::query()->where('section_id', $section_id)->orderBy('order', 'asc')->get();
        return apiResponse(true, 200, $tasks);
    }

    public function show($task_id)
    {
        $task = Task::query()->findOr($task_id, function () {
            return apiResponse(false, 404, __('words.Task not found'));
        });
        return apiResponse(true, 200, new TaskResource($task));
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


            DB::commit();
            return apiResponse(true, 200, __('words.Successfully updated'));
        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, 500, $e->getMessage());
        }
    }

    public function delete(Task $task)
    {
        $task->delete();

        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
