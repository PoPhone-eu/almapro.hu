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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('type')->index()->default('IPhone');
            $table->string('slug')->index();
            $table->longText('description')->nullable();
            $table->integer('position')->index()->nullable();
            $table->integer('provider_id')->index()->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->index()->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
