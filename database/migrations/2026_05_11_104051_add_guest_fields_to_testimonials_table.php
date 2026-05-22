// database/migrations/2026_05_11_xxxxxx_add_guest_fields_to_testimonials_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestFieldsToTestimonialsTable extends Migration
{
    public function up()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            if (!Schema::hasColumn('testimonials', 'email')) {
                $table->string('email')->nullable()->after('client_name');
            }
            if (!Schema::hasColumn('testimonials', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('testimonials', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('status');
            }
            if (!Schema::hasColumn('testimonials', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('is_verified');
            }
        });
    }

    public function down()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone', 'is_verified', 'submitted_at']);
        });
    }
}