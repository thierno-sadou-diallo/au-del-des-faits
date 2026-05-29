<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'halimatouk484@gmail.com'],
            [
                'name' => 'Halimatou Keita',
                'password' => 'admin@123',
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            BlogPortfolioSeeder::class,
        ]);
    }
}
