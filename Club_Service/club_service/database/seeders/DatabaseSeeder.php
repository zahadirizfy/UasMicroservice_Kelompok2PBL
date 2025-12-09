<?php

namespace Database\Seeders;

use App\Models\Club;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample clubs
        $clubs = [
            [
                'name' => 'Persib Bandung',
                'description' => 'Persatuan Sepak Bola Indonesia Bandung, dikenal sebagai Maung Bandung',
                'city' => 'Bandung',
                'stadium' => 'Stadion Si Jalak Harupat',
                'founded_year' => 1933,
                'logo_url' => 'https://example.com/persib-logo.png',
            ],
            [
                'name' => 'Persija Jakarta',
                'description' => 'Persatuan Sepak Bola Indonesia Jakarta, dikenal sebagai Macan Kemayoran',
                'city' => 'Jakarta',
                'stadium' => 'Stadion Utama Gelora Bung Karno',
                'founded_year' => 1928,
                'logo_url' => 'https://example.com/persija-logo.png',
            ],
            [
                'name' => 'Arema FC',
                'description' => 'Arema Football Club, dikenal sebagai Singo Edan',
                'city' => 'Malang',
                'stadium' => 'Stadion Kanjuruhan',
                'founded_year' => 1987,
                'logo_url' => 'https://example.com/arema-logo.png',
            ],
            [
                'name' => 'PSM Makassar',
                'description' => 'Persatuan Sepak Bola Makassar, dikenal sebagai Juku Eja',
                'city' => 'Makassar',
                'stadium' => 'Stadion Mattoangin',
                'founded_year' => 1915,
                'logo_url' => 'https://example.com/psm-logo.png',
            ],
            [
                'name' => 'Bali United',
                'description' => 'Bali United Football Club, Tim kebanggaan pulau dewata',
                'city' => 'Gianyar',
                'stadium' => 'Stadion Kapten I Wayan Dipta',
                'founded_year' => 1989,
                'logo_url' => 'https://example.com/bali-united-logo.png',
            ],
        ];

        foreach ($clubs as $club) {
            Club::create($club);
        }
    }
}

