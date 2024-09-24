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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->nullable()->index();
            $table->string('normal_image')->nullable();
            $table->string('mobile_image')->nullable();
            // display from and to dates
            $table->date('from_date')->nullable()->index();
            $table->date('to_date')->nullable()->index();
            // is active
            $table->boolean('is_active')->default(true)->index();
            // chances of showing
            $table->integer('chance')->nullable()->index();
            // amount payed
            $table->integer('amount_payed')->nullable()->index();  // amount * 100
            // timestamps
            $table->timestamps();
            // belongs to user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
