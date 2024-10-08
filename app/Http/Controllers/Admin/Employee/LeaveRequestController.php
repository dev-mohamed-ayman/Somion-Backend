<?php

namespace App\Http\Controllers\Admin\employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\LeaveRequestRequest;
use App\Http\Resources\Api\Admin\employee\LeaveRequestResource;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveRequestController extends Controller
{
    public function all(Request $request)
    {
        $leaveRequests = LeaveRequest::query()
            ->when($request->employee_id, function ($q) use ($request) {
                $q->where('employee_id', $request->employee_id);
            })
            ->latest()
            ->paginate(limit(request()->limit));

        return apiResponse(true, 200, [
            'leave_requests' => LeaveRequestResource::collection($leaveRequests),
            'pagination' => pagination($leaveRequests),
        ]);
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leave_request_id' => ['required', 'exists:leave_requests,id'],
            'status' => ['required', 'in:approved,rejected'],
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        $leaveRequest = LeaveRequest::findOr($request->leave_request_id, function () {
            return __('words.Leave request not found');
        });
        $leaveRequest->status = $request->status;
        $leaveRequest->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    public function index()
    {
        if (auth()->user()->type !== 'employee') {
            return apiResponse(false, 403, __('words.You are not allowed to'));
        }

        $leaveRequests = LeaveRequest::query()
            ->where('employee_id', auth()->user()->employee->id)
            ->latest()
            ->paginate(limit(request()->limit));

        return apiResponse(true, 200, [
            'leave_requests' => LeaveRequestResource::collection($leaveRequests),
            'pagination' => pagination($leaveRequests),
        ]);
    }

    public function store(LeaveRequestRequest $request)
    {
        if (auth()->user()->type !== 'employee') {
            return apiResponse(false, 403, __('words.You are not allowed to'));
        }

        LeaveRequest::create([
            'employee_id' => auth()->user()->employee->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'type' => $request->type,
            'reason' => $request->reason,
        ]);
        return apiResponse(true, 201, __('words.Successfully created'));
    }

    public function update($id, LeaveRequestRequest $request)
    {
        if (auth()->user()->type !== 'employee') {
            return apiResponse(false, 403, __('words.You are not allowed to'));
        }
        $leaveRequest = LeaveRequest::findOr($id, function () {
            return __('words.Leave request not found');
        });
        if ($leaveRequest->status !== 'pending') {
            return apiResponse(false, 403, __('words.You are not allowed to update this leave request'));
        }
        $leaveRequest->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'type' => $request->type,
            'reason' => $request->reason,
        ]);
        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    public function destroy($id)
    {
        $leaveRequest = LeaveRequest::findOr($id, function () {
            return __('words.Leave request not found');
        });

        if ($leaveRequest->status !== 'pending') {
            return apiResponse(false, 403, __('words.You are not allowed to update this leave request'));
        }

        $leaveRequest->delete();

        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
