<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Kalau tidak pakai factory dummy:
        // User::factory(10)->create();

        // Panggil seeder spesifik
        $this->call([
            UserSeeder::class,
        ]);
    }
}
