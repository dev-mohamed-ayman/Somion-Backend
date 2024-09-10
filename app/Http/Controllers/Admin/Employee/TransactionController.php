<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\Transaction\TransactionStoreRequest;
use App\Http\Requests\Admin\Employee\Transaction\TransactionUpdateRequest;
use App\Http\Resources\Api\Admin\Employee\TransactionResource;
use App\Models\EmployeeTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $employeeTransactions = EmployeeTransaction::query()->latest()->paginate(limit($request->limit));
        return apiResponse(true, 200, [
            'transactions' => TransactionResource::collection($employeeTransactions),
            'pagination' => pagination($employeeTransactions)
        ]);
    }

    public function store(TransactionStoreRequest $request)
    {
        $employeeTransaction = new EmployeeTransaction();
        $employeeTransaction->employee_id = $request->employee_id;
        $employeeTransaction->amount = $request->amount;
        $employeeTransaction->type = $request->type;
        $employeeTransaction->reason = $request->reason;
        $employeeTransaction->save();

        return apiResponse(true, 200, __('words.Employee transaction added successfully'));
    }

    public function show($id,)
    {
        $employeeTransaction = EmployeeTransaction::query()->findOr($id, function () {
            return apiResponse(true, 200, __('words.Employee transaction not found'));
        });

        return apiResponse(true, 200, new TransactionResource($employeeTransaction));
    }

    public function update(TransactionUpdateRequest $request, $id)
    {
        $employeeTransaction = EmployeeTransaction::query()->findOr($id, function () {
            return apiResponse(true, 200, __('words.Employee transaction not found'));
        });

        $employeeTransaction->amount = $request->amount;
        $employeeTransaction->type = $request->type;
        $employeeTransaction->reason = $request->reason;
        $employeeTransaction->save();

        return apiResponse(true, 200, __('words.Employee transaction added successfully'));

    }

    public function destroy($id)
    {
        $employeeTransaction = EmployeeTransaction::query()->findOr($id, function () {
            return apiResponse(true, 200, __('words.Employee transaction not found'));
        });

        $employeeTransaction->delete();

        return apiResponse(true, 200, __('words.Employee transaction deleted successfully'));
    }
}
