<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersData = [
            [
                'check' => [
                    'email' => 'admin@gmail.com',
                ],
                'data' => [
                    'name' => 'Admin Adminadze',
                    'email_verified_at' => now(),
                    'password' => Hash::make('admin'),
                ],
            ],
            [
                'check' => [
                    'email' => 'manager@gmail.com',
                ],
                'data' => [
                    'name' => 'Manager Manageradze',
                    'email_verified_at' => now(),
                    'password' => Hash::make('manager'),
                ],
            ],
            [
                'check' => [
                    'email' => 'user@gmail.com',
                ],
                'data' => [
                    'name' => 'User Useradze',
                    'email_verified_at' => now(),
                    'password' => Hash::make('user'),
                ],
            ],
        ];

        foreach ($usersData as $userData) {
            User::firstOrCreate($userData['check'], $userData['data']);
        }
    }
}
