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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('delivery')->default(false)->index()->after('description');
            $table->string('delivery_price')->nullable()->index()->after('delivery');
            $table->boolean('local_pickup')->default(true)->index()->after('delivery_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['delivery', 'delivery_price', 'local_pickup']);
        });
    }
};
