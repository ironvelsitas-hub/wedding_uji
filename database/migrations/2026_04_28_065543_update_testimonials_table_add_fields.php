// database/migrations/2024_01_01_000008_update_testimonials_table_add_fields.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTestimonialsTableAddFields extends Migration
{
    public function up()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('couple_name')->nullable()->after('client_name');
            $table->string('wedding_date')->nullable()->after('message');
            $table->string('venue')->nullable()->after('wedding_date');
            $table->string('package_used')->nullable()->after('venue');
            $table->string('video_url')->nullable()->after('photo');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('video_url');
            $table->boolean('is_featured')->default(false)->after('status');
            $table->date('testimonial_date')->nullable()->after('is_featured');
        });
    }

    public function down()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn([
                'couple_name', 'wedding_date', 'venue', 'package_used',
                'video_url', 'status', 'is_featured', 'testimonial_date'
            ]);
        });
    }
}