<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'type' => 'admin',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Employee',
                'username' => 'employee',
                'email' => 'employee@employee.com',
                'type' => 'employee',
                'password' => bcrypt('password'),
            ], [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@user.com',
                'type' => 'user',
                'password' => bcrypt('password'),
            ],
        ];

        User::query()->delete();

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
