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
        Schema::create('doi_percentages', function (Blueprint $table) {
            $table->id();
            $table->integer('min_days')->comment('Batas minimum hari (inclusive)');
            $table->integer('max_days')->nullable()->comment('Batas maximum hari (inclusive), NULL = tidak terbatas');
            $table->decimal('percentage', 5, 2)->comment('Persentase DOI (misal: 2.00 = 2%)');
            $table->string('label')->nullable()->comment('Keterangan range (misal: 60-120 hari)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doi_percentages');
    }
};