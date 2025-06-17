<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator Sistem',
            ],
            [
                'name' => 'student',
                'description' => 'Mahasiswa',
            ],
            [
                'name' => 'supervisor',
                'description' => 'Dosen Pembimbing',
            ],
            [
                'name' => 'field_supervisor',
                'description' => 'Pembimbing Lapangan',
            ],
            [
                'name' => 'coordinator',
                'description' => 'Koordinator PKL',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }
}
