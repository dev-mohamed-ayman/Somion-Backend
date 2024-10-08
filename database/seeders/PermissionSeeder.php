<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::query()->delete();

        $permissions = [
            ['name' => 'Employees'],

            ['name' => 'Employees management'],
            ['name' => 'Add employee'],
            ['name' => 'update employee'],
            ['name' => 'delete employee'],

            ['name' => 'Employees jobs'],
            ['name' => 'Add employee job'],
            ['name' => 'update employee job'],
            ['name' => 'delete employee job'],

            ['name' => 'Employees loans'],
            ['name' => 'Add employee loan'],
            ['name' => 'delete employee loan'],

            ['name' => 'Employees transactions'],
            ['name' => 'Add employee transaction'],
            ['name' => 'update employee transaction'],
            ['name' => 'delete employee transaction'],

            ['name' => 'MarkAsPaid employee payrolls'],

            ['name' => 'Projects'],

            ['name' => 'Clients'],
            ['name' => 'Add client'],
            ['name' => 'delete client'],
            ['name' => 'update client'],

            ['name' => 'Projects management'],
            ['name' => 'Add project'],
            ['name' => 'Update project'],
            ['name' => 'Delete project'],
            ['name' => 'More details project'],
            ['name' => 'Reorder project'],

            ['name' => 'Tasks'],
            ['name' => 'Add task'],
            ['name' => 'Delete task'],
            ['name' => 'Add task section'],
            ['name' => 'Update task section'],
            ['name' => 'Delete task section'],
            ['name' => 'Reorder task'],
            ['name' => 'Reorder task section'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Grant all permissions to 'admin' role
        $admin = \Spatie\Permission\Models\Role::findByName('admin');
        $admin->givePermissionTo(Permission::all());

        // Grant all permissions to 'employee' role
        $employee = \Spatie\Permission\Models\Role::findByName('employee');
        $employeePermissions = Permission::query()->whereIn('name', [
            'Projects',
            'Projects management',
            'More details project',
            'Tasks',
            'Update task section',
            'Reorder task',
        ])->get();
        $employee->givePermissionTo($employeePermissions);

        // Grant all permissions to 'hr' role
        $hr = \Spatie\Permission\Models\Role::findByName('hr');
        $hrPermissions = Permission::query()->whereIn('name', [
            'Employees',
            'Employees management',
            'Employees loans',
            'Employees transactions',
            'MarkAsPaid employee payrolls',
        ])->get();
        $hr->givePermissionTo($hrPermissions);

    }
}
