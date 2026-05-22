<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePortfolioTableAddFields extends Migration
{
    public function up()
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('category')->after('title')->default('wedding');
            $table->string('client_name')->nullable()->after('description');
            $table->string('venue')->nullable()->after('client_name');
            $table->json('gallery')->nullable()->after('image'); // Untuk multiple images
            $table->boolean('is_featured')->default(false)->after('gallery');
            $table->string('video_url')->nullable()->after('is_featured');
        });
    }

    public function down()
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['category', 'client_name', 'venue', 'gallery', 'is_featured', 'video_url']);
        });
    }
}