<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'halimatou484@gmail.com'],
            [
                'name' => 'Admin',
                'email' => 'halimatou484@gmail.com',
                'password' => Hash::make('admin@123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
