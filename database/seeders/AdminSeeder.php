<?php

namespace Database\Seeders;

use App\Models\AdminAuth;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!AdminAuth::where('email', 'admin@glow-up.kz')->exists()) {
            AdminAuth::create([
                'name'     => 'Admin',
                'email'    => 'admin@glow-up.kz',
                'password' => bcrypt('123456'),
            ]);
        }
    }
}