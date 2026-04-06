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
            ['email' => 'admin@verandstore.id'],
            [
                'name'     => 'Admin Verand',
                'password' => Hash::make('admin123456'),
                'role'     => 'admin',
                'phone'    => '081234567890',
            ]
        );

        User::updateOrCreate(
            ['email' => 'demo@verandstore.id'],
            [
                'name'     => 'Demo User',
                'password' => Hash::make('demo123456'),
                'role'     => 'customer',
                'phone'    => '089876543210',
            ]
        );
    }
}
