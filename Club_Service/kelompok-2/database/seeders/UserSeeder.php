<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Porlempika',
            'phone_number' => '081234567890',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'is_approved' => true,
        ]);

        // Klub
        User::create([
            'name' => 'Klub Bukit Tinggi',
            'phone_number' => '082211223344',
            'email' => 'klub@gmail.com',
            'password' => Hash::make('klub'),
            'role' => 'klub',
            'is_approved' => true,
        ]);

        // Atlet
        User::create([
            'name' => 'Atlet Andalas',
            'phone_number' => '083311223344',
            'email' => 'atlet@gmail.com',
            'password' => Hash::make('atlet'),
            'role' => 'atlet',
            'is_approved' => true,
        ]);

        // Anggota
        User::create([
            'name' => 'Anggota Minangkabau',
            'phone_number' => '084411223344',
            'email' => 'anggota@gmail.com',
            'password' => Hash::make('anggota'),
            'role' => 'anggota',
            'is_approved' => true,
        ]);

        // Juri
        User::create([
            'name' => 'Juri Padang',
            'phone_number' => '085511223344',
            'email' => 'juri@gmail.com',
            'password' => Hash::make('juri'),
            'role' => 'juri',
            'is_approved' => true,
        ]);

        // Penyelenggara
        User::create([
            'name' => 'Penyelenggara Event A',
            'phone_number' => '086611223344',
            'email' => 'penyelenggara@gmail.com',
            'password' => Hash::make('penyelenggara'),
            'role' => 'penyelenggara',
            'is_approved' => true,
        ]);
    }
}
