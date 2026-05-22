<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah admin sudah ada, jika belum buat baru
        Admin::updateOrCreate(
            ['email' => 'admin@perfectwedding.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@perfectwedding.com',
                'password' => Hash::make('password'),
            ]
        );
        
        // Tambah admin alternatif (opsional)
        Admin::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin Utama',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
            ]
        );
        
        $this->command->info('Admin user seeded successfully!');
    }
}