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
        Schema::create('banner_positions', function (Blueprint $table) {
            $table->id();
            $table->string('position_name')->index();
            $table->integer('chance')->nullable()->index();
            $table->timestamps();
            // relations to Banner model
            $table->foreignId('banner_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_positions');
    }
};
