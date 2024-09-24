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
        // many to many relationship for products and shops
        Schema::create('product_shop', function (Blueprint $table) {
            $table->unsignedBiginteger('product_id')->unsigned();
            $table->unsignedBiginteger('shop_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_shop');
    }
};
