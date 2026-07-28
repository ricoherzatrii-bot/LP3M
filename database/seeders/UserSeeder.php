<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'name' => 'Admin Utama',
                'username' => 'admin',
                'email' => 'admin@poljam.ac.id',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]);
        }
    }
}
