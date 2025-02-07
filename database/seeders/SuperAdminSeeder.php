<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('role', 'super_admin')->count() === 0) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@notenest.com',
                'password' => Hash::make('admin123'),
                'role' => 'super_admin',
            ]);
        }
    }
} 