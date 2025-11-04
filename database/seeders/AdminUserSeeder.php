<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@f1.local'],
            ['name' => 'Admin', 'password' => 'admin123', 'role' => 'admin']
        );
    }
}
