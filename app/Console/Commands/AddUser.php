<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add {role} {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new user with role, name, email, and password';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $role = $this->argument('role');
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Define allowed roles
        $allowedRoles = ['site_manager', 'retailer', 'wholesaler'];

        // Validate email, role, and other fields
        $validator = Validator::make(
            [
                'email' => $email,
                'role' => $role,
                'name' => $name,
                'password' => $password,
            ],
            [
                'email' => 'required|email|unique:users,email',
                'role' => 'required|string|in:' . implode(',', $allowedRoles),
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8',
            ]
        );

        if ($validator->fails()) {
            $this->error('Validation error: ' . implode(', ', $validator->errors()->all()));
            return 1;
        }

        // Create the user
        $user = User::create([
            'role' => $role,
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("User '{$user->name}' has been created successfully with the role of '{$user->role}'.");
        return 0;
    }
}
