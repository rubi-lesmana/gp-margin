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
        Schema::create('categories', function (Blueprint $table) {
            $table->string('status', 15)->primary();
            $table->integer('min_quantity')->comment('Batas minimum quantity (inclusive)');
            $table->integer('max_quantity')->nullable()->comment('Batas maximum quantity (inclusive), NULL = tidak terbatas');
            $table->decimal('calculation', 5, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};