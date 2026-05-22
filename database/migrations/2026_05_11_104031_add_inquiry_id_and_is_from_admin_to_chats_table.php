// database/migrations/2026_05_11_xxxxxx_add_inquiry_id_and_is_from_admin_to_chats_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInquiryIdAndIsFromAdminToChatsTable extends Migration
{
    public function up()
    {
        Schema::table('chats', function (Blueprint $table) {
            if (!Schema::hasColumn('chats', 'inquiry_id')) {
                $table->foreignId('inquiry_id')->nullable()->after('session_id')->constrained('inquiries')->onDelete('cascade');
            }
            if (!Schema::hasColumn('chats', 'is_from_admin')) {
                $table->boolean('is_from_admin')->default(false)->after('is_read_visitor');
            }
        });
    }

    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropForeign(['inquiry_id']);
            $table->dropColumn(['inquiry_id', 'is_from_admin']);
        });
    }
}