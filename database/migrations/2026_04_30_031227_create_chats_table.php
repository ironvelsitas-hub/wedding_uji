<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->foreignId('inquiry_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('visitor_name')->nullable();
            $table->string('visitor_email')->nullable();
            $table->string('visitor_phone')->nullable();
            $table->text('message');
            $table->string('status')->default('pending');
            $table->boolean('is_read_admin')->default(false);
            $table->boolean('is_read_visitor')->default(true);
            $table->boolean('is_from_admin')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chats');
    }
}