<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create 
                           {--name= : Admin user name}
                           {--email= : Admin user email}
                           {--password= : Admin user password}
                           {--phone= : Admin user phone number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user for the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating a new admin user...');
        $this->newLine();

        // Get user input with validation
        $name = $this->option('name') ?: $this->ask('Admin Name');
        $email = $this->option('email') ?: $this->ask('Admin Email');
        $phone = $this->option('phone') ?: $this->ask('Admin Phone (optional)', null);
        
        // Get password securely
        $password = $this->option('password') ?: $this->secret('Admin Password (min 8 characters)');
        $confirmPassword = $this->option('password') ? $password : $this->secret('Confirm Password');

        // Validate input
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error('- ' . $error);
            }
            return Command::FAILURE;
        }

        // Check password confirmation
        if ($password !== $confirmPassword) {
            $this->error('Passwords do not match!');
            return Command::FAILURE;
        }

        // Check if admin already exists
        if (User::where('role', 'admin')->exists()) {
            if (!$this->confirm('An admin user already exists. Do you want to create another one?')) {
                $this->info('Operation cancelled.');
                return Command::SUCCESS;
            }
        }

        try {
            // Create the admin user
            $admin = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'phone' => $phone,
                'role' => 'admin',
                'status' => 'approved',
                'email_verified_at' => now(),
            ]);

            $this->newLine();
            $this->info('✅ Admin user created successfully!');
            $this->newLine();
            $this->table(
                ['Field', 'Value'],
                [
                    ['ID', $admin->id],
                    ['Name', $admin->name],
                    ['Email', $admin->email],
                    ['Phone', $admin->phone ?: 'Not provided'],
                    ['Role', $admin->role],
                    ['Status', $admin->status],
                    ['Created', $admin->created_at->format('Y-m-d H:i:s')],
                ]
            );
            $this->newLine();
            $this->info('You can now login to the admin panel at: /admin');
            
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Failed to create admin user: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
} 