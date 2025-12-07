<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'New Admin User',
            'email' => 'newadmin@example.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create additional admin users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567891',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin users created successfully!');
    }
}
