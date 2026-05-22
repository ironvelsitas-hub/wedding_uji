<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'name' => 'Dekorasi & Wedding',
                'description' => 'Dekorasi indoor dan outdoor dengan konsep modern dan elegan',
                'icon' => 'fas fa-ring',
                'image' => 'services/dekorasi.jpg'
            ],
            [
                'name' => 'Dokumentasi',
                'description' => 'Foto dan video profesional untuk mengabadikan momen spesial Anda',
                'icon' => 'fas fa-camera',
                'image' => 'services/dokumentasi.jpg'
            ],
            [
                'name' => 'Katering',
                'description' => 'Hidangan lezat dengan pilihan menu yang beragam',
                'icon' => 'fas fa-utensils',
                'image' => 'services/katering.jpg'
            ],
            [
                'name' => 'Makeup & Styling',
                'description' => 'Makeup artist profesional untuk pengantin dan keluarga',
                'icon' => 'fas fa-palette',
                'image' => 'services/makeup.jpg'
            ],
            [
                'name' => 'Entertainment',
                'description' => 'Live music, DJ, dan hiburan lainnya',
                'icon' => 'fas fa-music',
                'image' => 'services/entertainment.jpg'
            ],
            [
                'name' => 'Wedding Planner',
                'description' => 'Perencanaan pernikahan dari awal hingga hari H',
                'icon' => 'fas fa-calendar-alt',
                'image' => 'services/wedding-planner.jpg'
            ],
        ];
        
        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
        
        $this->command->info('Services seeded successfully!');
    }
}