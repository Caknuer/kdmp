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
        $adminEmail = env('ADMIN_EMAIL', 'studio.mazte@gmail.com');
        $adminPassword = env('ADMIN_PASSWORD', 'Admin1234!');

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
