<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = [
            [
                'title' => [
                    'en' => 'Fullstack Developer',
                    'de' => 'Fullstack-Entwickler'
                ]
            ],
            [
                'title' => [
                    'en' => 'Frontend Developer',
                    'de' => 'Frontend-Entwickler'
                ]
            ],
            [
                'title' => [
                    'en' => 'Backend Developer',
                    'de' => 'Backend-Entwickler'
                ]
            ],
            [
                'title' => [
                    'en' => 'UI&UX Designer',
                    'de' => 'UI/UX-Designer'
                ]
            ],
            [
                'title' => [
                    'en' => 'Project Manager',
                    'de' => 'Projektmanager'
                ]
            ],
            [
                'title' => [
                    'en' => 'SEO',
                    'de' => 'SEO-Spezialist'
                ]
            ],
            [
                'title' => [
                    'en' => 'Digital Marketing',
                    'de' => 'Digitales Marketing'
                ]
            ],
        ];

        foreach ($jobs as $job) {
            \App\Models\EmployeeJob::create($job);
        }
    }
}
