<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kantin.id'],
            [
                'name'              => 'Admin Kantin',
                'email'             => 'admin@kantin.id',
                'role'              => 'admin',
                'password'          => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin account created: admin@kantin.id / admin123');
    }
}
