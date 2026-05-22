<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            [
                'name' => 'Paket Silver',
                'description' => 'Paket ekonomis dengan layanan dasar',
                'price' => 25000000,
                'features' => [
                    'Dekorasi sederhana',
                    'Dokumentasi foto',
                    'Undangan 100 pcs',
                    'Wedding organizer'
                ],
                'is_popular' => false
            ],
            [
                'name' => 'Paket Gold',
                'description' => 'Paket lengkap untuk pernikahan impian',
                'price' => 50000000,
                'features' => [
                    'Dekorasi premium',
                    'Dokumentasi foto & video',
                    'Makeup pengantin',
                    'Undangan 200 pcs',
                    'Wedding organizer',
                    'Katering untuk 100 orang'
                ],
                'is_popular' => true
            ],
            [
                'name' => 'Paket Platinum',
                'description' => 'Paket eksklusif dengan layanan lengkap',
                'price' => 100000000,
                'features' => [
                    'Dekorasi mewah',
                    'Dokumentasi foto & video cinematic',
                    'Makeup & styling lengkap',
                    'Undangan 300 pcs',
                    'Wedding organizer premium',
                    'Katering untuk 200 orang',
                    'Live music',
                    'Fotobooth'
                ],
                'is_popular' => false
            ],
        ];
        
        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['name' => $package['name']],
                $package
            );
        }
        
        $this->command->info('Packages seeded successfully!');
    }
}