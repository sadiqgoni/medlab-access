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
        // Check if admin already exists
        if (User::where('role', 'admin')->exists()) {
            $this->command->warn('Admin user already exists. Skipping admin creation.');
            return;
        }

        // Create default admin user
        $admin = User::create([
            'name' => env('ADMIN_NAME', 'System Administrator'),
            'email' => env('ADMIN_EMAIL', 'admin@gmail.com'),
            'password' => Hash::make(env('ADMIN_PASSWORD', '12345678')),
            'phone' => env('ADMIN_PHONE', null),
            'role' => 'admin',
            'status' => 'approved',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Admin user created successfully!');
        $this->command->table(
            ['Field', 'Value'],
            [
                ['ID', $admin->id],
                ['Name', $admin->name],
                ['Email', $admin->email],
                ['Role', $admin->role],
                ['Status', $admin->status],
            ]
        );
        $this->command->warn('⚠️  Remember to change the default password after first login!');
    }
} 