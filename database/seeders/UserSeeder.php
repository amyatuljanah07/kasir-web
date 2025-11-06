<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin Kasir',
                'email' => 'admin@kasir.com',
                'password' => Hash::make('admin123'),
                'role_id' => 1, // admin
                'is_member' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Pegawai Kasir',
                'email' => 'pegawai@kasir.com',
                'password' => Hash::make('pegawai123'),
                'role_id' => 2, // pegawai
                'is_member' => false,
                'is_active' => true,
            ],
            // Customer harus registrasi sendiri dengan email masing-masing
            // Tidak lagi menggunakan akun customer default
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']], // Cari berdasarkan email
                $userData // Update atau create dengan data ini
            );
        }
    }
}