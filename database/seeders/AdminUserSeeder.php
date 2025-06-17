<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin role
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            // Create default admin
            User::firstOrCreate(
                ['email' => 'admin@spektra.ac.id'],
                [
                    'name' => 'Admin SPEKTRA',
                    'password' => Hash::make('password'),
                    'role_id' => $adminRole->id,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
