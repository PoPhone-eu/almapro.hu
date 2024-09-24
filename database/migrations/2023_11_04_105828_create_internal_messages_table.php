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
        Schema::create('internal_messages', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name');
            $table->integer('senderid');
            $table->string('recepient_name');
            $table->integer('owner_id')->nullable();
            $table->integer('recepient_message_id')->nullable();
            $table->longText('body')->nullable();
            $table->string('subject')->nullable();
            $table->boolean('copies')->default(false);
            $table->string('original_recepient_name')->nullable();
            $table->integer('original_recepient_id')->nullable();
            $table->boolean('has_attachment')->default(false);
            $table->boolean('seen')->default(false);
            $table->boolean('draft')->default(false);
            $table->boolean('urgent')->default(false);   // sender marked it as urgent
            $table->boolean('starred')->default(false);     // receiver marked it as important/starred
            $table->softDeletes();
            $table->timestamps();
            $table->foreignId('sender_id')->index()->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('sent_to_id')->index()->nullable()->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_messages');
    }
};
