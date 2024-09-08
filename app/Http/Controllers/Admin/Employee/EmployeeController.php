<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\StoreEmployeeRequest;
use App\Http\Requests\Admin\Employee\UpdateEmployeeRequest;
use App\Http\Resources\Api\Admin\Employee\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::query()->latest()->paginate(limit($request->limit));

        return apiResponse(true, 200, [
            'employees' => EmployeeResource::collection($employees),
            'pagination' => pagination($employees)
        ]);
    }

    public function create(StoreEmployeeRequest $request)
    {
        DB::beginTransaction();
        try {

            // Create a new user in the database
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = bcrypt('secret');
            $user->type = 'employee';
            if ($request->hasFile('image')) {
                $user->image = uploadFile('users', $request->file('image'));
            }
            $user->save();

            // Create a new employee database
            $employee = new Employee();
            $employee->user_id = $user->id;
            $employee->employee_job_id = $request->employee_job_id;
            $employee->employment_status_id = $request->employment_status_id;
            $employee->date_of_birth = $request->date_of_birth;
            $employee->gender = $request->gender;
            $employee->address = $request->address;
            $employee->joining_date = $request->joining_date;
            $employee->salary = $request->salary;
            $employee->payment_information = $request->payment_information;
            $employee->save();

            DB::commit();
            return apiResponse(true, 201, __('words.Employee created successfully'));

        } catch (\Exception $exception) {
            return apiResponse(false, 400, $exception->getMessage());
        }
    }

    public function show(Employee $employee)
    {
        return apiResponse(true, 200, [
            'employee' => new EmployeeResource($employee)
        ]);
    }

    public function update(Employee $employee, UpdateEmployeeRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'username' => 'unique:users,username,' . $employee->user_id,
                'email' => 'unique:users,email,' . $employee->user_id,
            ]);


            $employee->employee_job_id = $request->employee_job_id;
            $employee->employment_status_id = $request->employment_status_id;
            $employee->date_of_birth = $request->date_of_birth;
            $employee->gender = $request->gender;
            $employee->address = $request->address;
            $employee->joining_date = $request->joining_date;
            $employee->salary = $request->salary;
            $employee->payment_information = $request->payment_information;
            $employee->save();

            $user = User::query()->where('id', $employee->user_id)->first();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->phone = $request->phone;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = bcrypt('secret');
            }
            if ($request->hasFile('image')) {
                deleteFile($user->image);
                $user->image = uploadFile('users', $request->file('image'));
            }
            $user->save();

            DB::commit();
            return apiResponse(true, 201, __('words.Employee updated successfully'));

        } catch (\Exception $exception) {
            return apiResponse(false, 400, [$exception->getMessage()]);
        }
    }

    public function destroy(Employee $employee)
    {
        deleteFile($employee->user->image);
        $employee->user()->delete();
        $employee->delete();
        return apiResponse(true, 200, __('words.Employee deleted successfully'));
    }
}
