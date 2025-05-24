<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Only create admin if none exists and we're in development or explicitly requested
        if (!User::where('role', 'admin')->exists() && 
            (app()->environment('local') || env('CREATE_ADMIN_USER', false))) {
            
            User::create([
                'name' => env('ADMIN_NAME', 'System Administrator'),
                'email' => env('ADMIN_EMAIL', 'admin@dhrspace.com'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin123456')),
                'phone' => env('ADMIN_PHONE', null),
                'role' => 'admin',
                'status' => 'approved',
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Admin user created successfully!');
        }

        // User::factory(10)->create();

        // Remove the test user creation in production
        if (app()->environment('local')) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }
    }
}
