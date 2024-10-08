<?php

namespace App\Http\Controllers\Admin\employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\employee\AttendanceResource;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function index()
    {
        if (auth()->user()->type !== 'employee') {
            return apiResponse(false, 403, __('words.You are not allowed to'));
        }
        $attendances = Attendance::query()
            ->where('employee_id', auth()->user()->employee->id)
            ->paginate(limit(\request()->limit));
        return apiResponse(true, 200, [
            'attendances' => AttendanceResource::collection($attendances),
            'pagination' => pagination($attendances)
        ]);
    }

    public function all(Request $request)
    {
        $attendances = Attendance::query()
            ->when($request->employee_id, function ($q) use ($request) {
                $q->where('employee_id', $request->employee_id);
            })
            ->paginate(limit($request->limit));
        return apiResponse(true, 200, [
            'attendances' => AttendanceResource::collection($attendances),
            'pagination' => pagination($attendances)
        ]);
    }

    public function checkIn(Request $request)
    {
        if (auth()->user()->type !== 'employee') {
            return apiResponse(false, 403, __('words.You are not allowed to'));
        }

        $employeeId = auth()->user()->employee->id;
        $today = now()->format('Y-m-d');

        Attendance::firstOrCreate(
            ['employee_id' => $employeeId, 'date' => $today],
            ['check_in' => now()]
        );

        return apiResponse(true, 201, __('words.Check-in recorded'));
    }

    public function checkOut(Request $request)
    {
        if (auth()->user()->type !== 'employee') {
            return apiResponse(false, 403, __('words.You are not allowed to'));
        }

        $employeeId = auth()->user()->employee->id;
        $today = now()->format('Y-m-d');

        $attendance = Attendance::where('employee_id', $employeeId)->where('date', $today)->first();

        if ($attendance && !$attendance->check_out) {
            $attendance->update(['check_out' => now()]);
            return apiResponse(true, 200, __('words.Check-out recorded'));
        }

        return apiResponse(false, 400, __('words.No check-in found or already checked out'));
    }
}
