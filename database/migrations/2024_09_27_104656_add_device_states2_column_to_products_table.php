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
            // állapot
            $table->string('macbook-evjarat')->nullable()->index()->after('macbook-tarhely-tipus');
            $table->string('macbook-kepernyo-meret')->nullable()->index()->after('macbook-evjarat');
            $table->string('billentyuzet-tipus')->nullable()->index()->after('macbook-kepernyo-meret');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
