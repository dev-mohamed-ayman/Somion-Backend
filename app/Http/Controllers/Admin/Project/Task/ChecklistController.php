<?php

namespace App\Http\Controllers\Admin\Project\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Project\Task\CreateChecklistRequest;
use App\Http\Requests\Admin\Project\Task\UpdateChecklistRequest;
use App\Models\TaskChecklist;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function create(CreateChecklistRequest $request)
    {
        $taskChecklist = new TaskChecklist();
        $taskChecklist->task_id = $request->task_id;
        $taskChecklist->text = $request->text;
        $taskChecklist->save();
        return apiResponse(true, 201, __('words.Successfully created'));
    }

    public function update(TaskChecklist $taskChecklist, UpdateChecklistRequest $request)
    {
        $taskChecklist->text = $request->text;
        $taskChecklist->completed = $request->completed;
        $taskChecklist->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    public function complete(TaskChecklist $taskChecklist)
    {
        $taskChecklist->completed = !$taskChecklist->completed;
        $taskChecklist->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    public function destroy(TaskChecklist $taskChecklist)
    {
        $taskChecklist->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
