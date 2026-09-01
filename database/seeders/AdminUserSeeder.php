<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = config('admin.email');
        $adminPassword = config('admin.password');

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin KDMP',
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}
