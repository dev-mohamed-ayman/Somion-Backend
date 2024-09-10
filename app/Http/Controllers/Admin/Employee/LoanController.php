<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\LoanRequest;
use App\Http\Resources\Api\Admin\Employee\LoanResource;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $loans = Loan::query()->latest()->paginate(limit($request->limit));
        return apiResponse(true, 200, [
            'loans' => LoanResource::collection($loans),
            'pagination' => pagination($loans),
        ]);
    }

    public function store(LoanRequest $request)
    {
        $loan = new Loan();
        $loan->employee_id = $request->employee_id;
        $loan->total_amount = $request->total_amount;
        $loan->remaining_amount = $request->total_amount;
        $loan->installments_count = $request->installments_count;
        $loan->start_date = $request->start_date;
        $loan->save();
        return apiResponse(true, 201, __('words.Loan added successfully'));
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        return apiResponse(true, 200, __('words.Loan deleted successfully'));
    }
}
