<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::select('id', 'name')->get();
        return apiResponse(true, 200, $roles);
    }

    public function permissions()
    {
        $permissions = Permission::select('id', 'name')->get();
        return apiResponse(true, 200, $permissions);
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles,name',
                'permissions' => 'required|array',
                'permissions.*' => 'required_with:permissions|exists:permissions,id',
            ]);
            if ($validator->fails()) {
                return apiResponse(false, 422, $validator->messages()->all());
            }

            $permissions = Permission::query()->whereIn('id', $request->permissions)->get();
            $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
            $role->syncPermissions($permissions);

            DB::commit();
            return apiResponse(true, 201, __('words.Successfully created'));

        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, 500, $e->getMessage());
        }
    }

    public function show($id)
    {
        $role = Role::query()
            ->where('id', $id)
            ->select('id', 'name')
            ->with(['permissions:id,name'])
            ->first();

        // Hide the pivot data for the permissions
        if ($role) {
            $role->permissions->makeHidden('pivot');
        } else {
            return apiResponse(false, 404, __('words.Role not found'));
        }

        return apiResponse(true, 200, $role);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles,name,' . $id,
                'permissions' => 'required|array',
                'permissions.*' => 'required_with:permissions|exists:permissions,id',
            ]);
            if ($validator->fails()) {
                return apiResponse(false, 422, $validator->messages()->all());
            }

            $permissions = Permission::query()->whereIn('id', $request->permissions)->get();
            $role = Role::query()->where('id', $id)->first();
            if (!$role) {
                return apiResponse(false, 404, __('words.Role not found'));
            }
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($permissions);

            DB::commit();
            return apiResponse(true, 201, __('words.Successfully updated'));

        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, 500, $e->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return apiResponse(true, 204, __('words.Successfully deleted'));
    }
}
