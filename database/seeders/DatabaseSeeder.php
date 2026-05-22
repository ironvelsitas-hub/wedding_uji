<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Package;
use App\Models\Testimonial;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Panggil semua seeder yang diperlukan
        $this->call([
            AdminSeeder::class,
            ServiceSeeder::class,
            PackageSeeder::class,
            TestimonialSeeder::class,
        ]);
        
        $this->command->info('All database seeders completed successfully!');
    }
}