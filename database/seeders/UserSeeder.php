<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates default users with host and guest roles
     * 6 hosts + 3 guests (Bangladeshi names)
     */
    public function run(): void
    {
        // Create 6 Host users with Bangladeshi names
        User::create([
            'username' => 'niloy',
            'email' => 'niloy@gmail.com',
            'password' => Hash::make('password1234'),
            'role' => 'host',
        ]);

        User::create([
            'username' => 'rafiq',
            'email' => 'rafiq@example.com',
            'password' => Hash::make('password123'),
            'role' => 'host',
        ]);

        User::create([
            'username' => 'tasnim',
            'email' => 'tasnim@example.com',
            'password' => Hash::make('password123'),
            'role' => 'host',
        ]);

        User::create([
            'username' => 'karim',
            'email' => 'karim@example.com',
            'password' => Hash::make('password123'),
            'role' => 'host',
        ]);

        User::create([
            'username' => 'sadia',
            'email' => 'sadia@example.com',
            'password' => Hash::make('password123'),
            'role' => 'host',
        ]);

        User::create([
            'username' => 'fahim',
            'email' => 'fahim@example.com',
            'password' => Hash::make('password123'),
            'role' => 'host',
        ]);

        // Create 3 Guest users with Bangladeshi names
        User::create([
            'username' => 'nusrat',
            'email' => 'nusrat@example.com',
            'password' => Hash::make('password123'),
            'role' => 'guest',
        ]);

        User::create([
            'username' => 'arif',
            'email' => 'arif@example.com',
            'password' => Hash::make('password123'),
            'role' => 'guest',
        ]);

        User::create([
            'username' => 'mim',
            'email' => 'mim@example.com',
            'password' => Hash::make('password123'),
            'role' => 'guest',
        ]);
    }
}
