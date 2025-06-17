<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            [
                'name' => 'Web Development',
                'description' => 'Pengembangan aplikasi berbasis web',
                'is_active' => true,
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Pengembangan aplikasi mobile (Android/iOS)',
                'is_active' => true,
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Desain antarmuka dan pengalaman pengguna',
                'is_active' => true,
            ],
            [
                'name' => 'Database Management',
                'description' => 'Pengelolaan database dan sistem informasi',
                'is_active' => true,
            ],
            [
                'name' => 'Network Engineering',
                'description' => 'Pengelolaan jaringan dan infrastruktur IT',
                'is_active' => true,
            ],
            [
                'name' => 'Data Science',
                'description' => 'Analisis data dan machine learning',
                'is_active' => true,
            ],
            [
                'name' => 'DevOps',
                'description' => 'Development dan Operations Engineering',
                'is_active' => true,
            ],
            [
                'name' => 'Cyber Security',
                'description' => 'Keamanan sistem dan jaringan',
                'is_active' => true,
            ],
            [
                'name' => 'Game Development',
                'description' => 'Pengembangan game dan multimedia interaktif',
                'is_active' => true,
            ],
            [
                'name' => 'IoT Engineering',
                'description' => 'Internet of Things dan Embedded Systems',
                'is_active' => true,
            ],
        ];

        foreach ($fields as $field) {
            Field::firstOrCreate(
                ['name' => $field['name']],
                [
                    'description' => $field['description'],
                    'is_active' => $field['is_active'],
                ]
            );
        }
    }
}
