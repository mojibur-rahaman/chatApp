<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('reciver_id');
            $table->foreign('reciver_id')->references('id')->on('users')->onDelete('cascade');;
            $table->longText('message');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_edited')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->boolean('deleted_from_sender')->default(false);
            $table->boolean('deleted_form_reciver')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
