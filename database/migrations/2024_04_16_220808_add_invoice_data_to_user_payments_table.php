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
        Schema::table('user_payments', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->index()->after('name');
            $table->date('payed_at')->nullable()->index()->after('invoice_number');
            $table->json('invoice_data')->nullable()->after('payed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_payments', function (Blueprint $table) {
            //
        });
    }
};
