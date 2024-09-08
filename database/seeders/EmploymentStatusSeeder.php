<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employmentStatuses = [
            [
                'title' => [
                    'en' => 'Full-Time Employee',
                    'de' => 'Vollzeitbeschäftigter'
                ]
            ],
            [
                'title' => [
                    'en' => 'Part-Time Employee',
                    'de' => 'Teilzeitbeschäftigter'
                ]
            ],
            [
                'title' => [
                    'en' => 'Temporary Employee',
                    'de' => 'Leiharbeiter'
                ]
            ],
            [
                'title' => [
                    'en' => 'Intern',
                    'de' => 'Praktikant'
                ]
            ],
            [
                'title' => [
                    'en' => 'Seasonal Employee',
                    'de' => 'Saisonarbeiter'
                ]
            ],
            [
                'title' => [
                    'en' => 'Freelancer/Contractor',
                    'de' => 'Freiberufler/Vertragspartner'
                ]
            ],
            [
                'title' => [
                    'en' => 'Remote Employee',
                    'de' => 'Remote-Mitarbeiter'
                ]
            ],
            [
                'title' => [
                    'en' => 'Probationary Employee',
                    'de' => 'Probezeit-Mitarbeiter'
                ]
            ],
        ];

        foreach ($employmentStatuses as $employmentStatus) {
            \App\Models\EmploymentStatus::create($employmentStatus);
        }
    }
}
