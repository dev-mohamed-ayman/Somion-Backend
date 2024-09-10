<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\Employee\PayrollResource;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        \DB::beginTransaction();
        try {

            $this->createPayrollForCurrentMonth();

            $payrolls = $this->getCurrentMonthPayrolls();


            \DB::commit();
            return apiResponse(true, 200, PayrollResource::collection($payrolls));
        } catch (\Exception $exception) {
            \DB::rollback();
            return apiResponse(false, 400, $exception->getMessage());
        }
    }

    public function markAsPaid($id)
    {
        $payroll = Payroll::query()->findOrFail($id);

        $payroll->is_paid = true;
        $payroll->payment_date = now();
        $payroll->save();

        return apiResponse(true, 200, __('words.Payroll marked as paid'));
    }

    public function getCurrentMonthPayrolls()
    {
        return Payroll::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->with('employee')->get();
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

            $salaryData = $this->calculateSalary($employee);

            $payroll = new Payroll();
            $payroll->employee_id = $employee->id;
            $payroll->base_salary = $salaryData['base_salary'];
            $payroll->total_loans = $salaryData['loan_deductions'];
            $payroll->salary = $salaryData['net_salary'];
            $payroll->total_deductions = $salaryData['deductions'];
            $payroll->total_bonuses = $salaryData['bonuses'];
            $payroll->payment_date = now();
            $payroll->save();
        }
    }

    public function calculateSalary($employee)
    {
        $baseSalary = $employee->salary;
        $loanDeductions = 0;
        $loans = $employee->loans()->where('start_date', '<=', now())->get();
        foreach ($loans as $loan) {
            if ($loan->installments_count > $loan->installments_paid) {
                $loanDeductions += ($loan->total_amount / $loan->installments_count);
                $loan->remaining_amount = $loan->remaining_amount - ($loan->total_amount / $loan->installments_count);
                $loan->installments_paid++;
                $loan->save();
            }
        }
        $deductions = $employee->deductions(true);
        $bonuses = $employee->bonuses(true);

        return [
            'base_salary' => $baseSalary,
            'loan_deductions' => $loanDeductions,
            'deductions' => $deductions,
            'bonuses' => $bonuses,
            'net_salary' => $baseSalary - $loanDeductions - $deductions + $bonuses
        ];
    }
}
