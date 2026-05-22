<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $testimonials = [
            [
                'client_name' => 'Andi & Siska',
                'message' => 'Terima kasih Perfect Wedding! Pernikahan kami berjalan sangat lancar dan sesuai keinginan. Tim sangat profesional dan detail.',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => true
            ],
            [
                'client_name' => 'Budi & Maya',
                'message' => 'Pelayanan sangat memuaskan, dekorasi sesuai dengan yang kami harapkan. Highly recommended!',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => true
            ],
            [
                'client_name' => 'Rudi & Anita',
                'message' => 'Terima kasih sudah membantu mewujudkan pernikahan impian kami. Semoga sukses selalu!',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => false
            ],
            [
                'client_name' => 'Dewi & Putra',
                'message' => 'Pelayanan sangat profesional, dekorasi cantik dan sesuai keinginan. Terima kasih Perfect Wedding!',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => false
            ],
            [
                'client_name' => 'Sari & Budi',
                'message' => 'Terima kasih tim Perfect Wedding yang sudah membuat hari pernikahan kami menjadi sangat istimewa. Semua berjalan lancar!',
                'rating' => 4,
                'status' => 'approved',
                'is_featured' => false
            ],
        ];
        
        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                [
                    'client_name' => $testimonial['client_name'], 
                    'message' => $testimonial['message']
                ],
                $testimonial
            );
        }
        
        $this->command->info('Testimonials seeded successfully!');
    }
}