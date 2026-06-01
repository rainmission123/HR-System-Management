<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('departments')->updateOrInsert(
            ['department' => 'Human Resources'],
            [
                'head_of' => 'HR Manager',
                'phone_number' => '0000000000',
                'email' => 'hr@example.com',
                'total_employee' => '0',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin User',
            'join_date' => now()->toDayDateTimeString(),
            'status' => 'Active',
            'role_name' => 'Admin',
            'position' => 'HR Manager',
            'department' => 'Human Resources',
            'password' => Hash::make('password'),
        ]);
    }
}
