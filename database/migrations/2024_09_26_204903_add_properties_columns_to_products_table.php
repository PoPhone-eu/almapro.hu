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
            //kijelzo
            $table->string('kijelzo')->nullable()->index()->after('provider_id');
            // keret
            $table->string('keret')->nullable()->index()->after('kijelzo');
            // hatlap
            $table->string('hatlap')->nullable()->index()->after('keret');
            // fedlap
            $table->string('fedlap')->nullable()->index()->after('hatlap');
            // haz
            $table->string('haz')->nullable()->index()->after('fedlap');
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
