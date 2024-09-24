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
        // a company can have many shops. A shop only belongs to one company.
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('shop_name')->nullable()->index();
            $table->string('shop_address')->nullable()->index();
            $table->string('shop_telephone')->nullable()->index();
            $table->timestamps();
            $table->foreignId('user_id')->index()->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
