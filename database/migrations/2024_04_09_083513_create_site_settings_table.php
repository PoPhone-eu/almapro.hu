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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('min_points')->default(2000)->index();
            $table->integer('featured_price')->default(100)->index();
            $table->integer('featured_days')->default(30)->index();
            $table->boolean('register_award')->default(0)->index();
            $table->integer('register_awared_points')->default(2000)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
