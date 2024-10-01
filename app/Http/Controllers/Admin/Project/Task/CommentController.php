<?php

namespace App\Http\Controllers\Admin\Project\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Project\Task\CreateCommentRequest;
use App\Http\Requests\Admin\Project\Task\UpdateCommentRequest;
use App\Http\Resources\Api\Admin\Project\Task\CommentResource;
use App\Models\TaskComment;
use App\Models\TaskCommentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function create(CreateCommentRequest $request)
    {
        DB::beginTransaction();
        try {
            if (!$request->input('comment') && !$request->input('files')) {
                return apiResponse(false, 422, __('words.No comment or file provided'));
            }

            $comment = new TaskComment();
            $comment->task_id = $request->input('task_id');
            $comment->comment = $request->input('comment');
            $comment->user_id = auth()->id();
            $comment->save();

            if ($request->attachments) {
                foreach ($request->attachments as $file) {
                    $commentFile = new TaskCommentFile();
                    $commentFile->task_comment_id = $comment->id;
                    $commentFile->path = uploadFile('comments', $file);
                    $commentFile->save();
                }
            }

            DB::commit();
            return apiResponse(true, 201, __('words.Successfully created'));

        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, 500, $e->getMessage());
        }
    }

    public function update(UpdateCommentRequest $request, TaskComment $taskComment)
    {

        if ($taskComment->user_id !== auth()->id()) {
            return apiResponse(false, 403, __('words.Unauthorized to update this comment'));
        }

        $taskComment->comment = $request->input('comment');
        $taskComment->save();

        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    public function deleteFile(TaskCommentFile $taskCommentFile)
    {
        deleteFile($taskCommentFile->path);
        $taskCommentFile->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }

    public function downloadFile(TaskCommentFile $taskCommentFile)
    {
        return response()->download($taskCommentFile->path);
    }
}
