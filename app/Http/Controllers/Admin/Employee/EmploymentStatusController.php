<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmploymentStatus;
use Illuminate\Http\Request;

class EmploymentStatusController extends Controller
{
    public function index()
    {
        $employmentStatuses = EmploymentStatus::query()->latest()->get();
        return apiResponse(true, 200, $employmentStatuses);
    }
}
