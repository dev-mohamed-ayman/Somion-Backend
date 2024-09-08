<?php

namespace App\Http\Controllers\Admin\Salary;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\Salary\PayrollResource;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->with('employee')
            ->get();

        return apiResponse(true, 200, PayrollResource::collection($payrolls));

    }

    public function createPayrollForCurrentMonth()
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            $existingPayroll = Payroll::where('employee_id', $employee->id)
                ->whereYear('payment_date', now()->year)
                ->whereMonth('payment_date', now()->month)
                ->first();

            if ($existingPayroll) {
                continue;
            }

            Payroll::create([
                'employee_id' => $employee->id,
                'salary' => $employee->salary, // يمكنك إضافة الخصومات والمكافآت هنا
                'payment_date' => now(),
                'is_paid' => false,
            ]);
        }
    }

    public function markAsPaid($payrollId)
    {
        $payroll = Payroll::findOrFail($payrollId);
        $payroll->is_paid = true;
        $payroll->save();

    }
}
