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
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->index();
            $table->string('product_name')->index();
            $table->integer('customer_id')->index();
            $table->string('customer_name')->index();
            $table->string('customer_email')->index()->nullable();
            $table->string('customer_phone')->index()->nullable();

            $table->integer('seller_id')->index();
            $table->string('seller_name')->index();

            $table->string('order_status')->index()->default('new');  // new, accepted, rejected, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_orders');
    }
};
