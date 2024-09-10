<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\EmployeeJobRequest;
use App\Http\Resources\Api\Admin\Employee\EmployeeJobResource;
use App\Models\EmployeeJob;
use Illuminate\Http\Request;

class EmployeeJobController extends Controller
{
    public function index()
    {
        $employeeJobs = EmployeeJob::query()->latest()->get();
        return apiResponse(true, 200, EmployeeJobResource::collection($employeeJobs));
    }

    public function store(EmployeeJobRequest $request)
    {
        $employeeJob = new EmployeeJob();
        $employeeJob->title = $request->title;
        $employeeJob->save();
        return apiResponse(true, 201, __('words.Employee job saved successfully'));
    }

    public function show(EmployeeJob $employeeJob)
    {
        return apiResponse(true, 200, $employeeJob);
    }

    public function update(EmployeeJobRequest $request, EmployeeJob $employeeJob) {
        $employeeJob->title = $request->title;
        $employeeJob->save();
        return apiResponse(true, 200, __('words.Employee job updated successfully'));
    }

    public function destroy(EmployeeJob $employeeJob) {
        $employeeJob->delete();
        return apiResponse(true, 200, __('words.Employee job deleted successfully'));
    }
}
