<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('ADMIN_PASSWORD');

        if (blank($password)) {
            if (app()->isProduction()) {
                throw new \RuntimeException('ADMIN_PASSWORD must be set before seeding an admin user in production.');
            }

            $password = 'admin@123';
        }

        User::updateOrCreate(
            ['email' => 'halimatouk484@gmail.com'],
            [
                'name' => 'Halimatou Keita',
                'password' => Hash::make($password),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            BlogPortfolioSeeder::class,
        ]);
    }
}
