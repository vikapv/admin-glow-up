<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@glow-up.kz')->exists()) {
            User::create([
                'name'     => 'Admin',
                'email'    => 'admin@glow-up.kz',
                'password' => bcrypt('123456'),
            ]);
        }
    }
}