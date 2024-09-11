<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     User::create([
    //         'name' => 'admin',
    //         'email' => 'admin@gmail.com',
    //         'email_verified_at' => now(),
    //         'password' => Hash::make('admin'), // password
    //     ])->assignRole('admin');
    // }


    public function run()
    {
        User::create([
            'name' => 'Admin User', // Provide a value for the 'name' field
            'username' => 'admin',
            'email' => 'admin@example.com', // Ensure you include the email if it's required
            'password' => Hash::make('admin'),
        ])->assignRole('admin');
    }
}
