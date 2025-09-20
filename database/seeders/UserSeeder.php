<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed a default user for login according to existing columns.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'firstname' => 'Admin',
                'lastname' => 'User',
                'username' => 'admin',
                'password' => 'password', // Will be hashed via cast
                'phone' => '08123456789',
                'role_id' => 1,
                'statut' => 1,
                'is_all_warehouses' => 1,
            ]
        );
    }
}


