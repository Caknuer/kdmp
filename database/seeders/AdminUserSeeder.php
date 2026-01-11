<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'Admin KDMP',
            'email' => 'admin@kdmp.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}
