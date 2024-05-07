<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin1234'), // Change 'password' to the desired password
            'role' => 'admin', // Set the role to 'admin'
        ]);

        
        // Create a regular user
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('user1234'), // Change 'password' to the desired password
            'role' => 'user', // Set the role to 'admin'
        ]);

    }
}
