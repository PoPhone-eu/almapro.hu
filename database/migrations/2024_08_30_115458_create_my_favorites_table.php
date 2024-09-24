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
        Schema::create('my_favorites', function (Blueprint $table) {
            $table->id();
            // product name
            $table->string('name')->nullable()->index();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // product_id as foreign key
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_favorites');
    }
};
