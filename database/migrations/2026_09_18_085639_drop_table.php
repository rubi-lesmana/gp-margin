<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Matikan pengecekan foreign key constraints sementara agar bisa drop table tanpa error
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('category');
        Schema::dropIfExists('doi_percentages');
        Schema::dropIfExists('item_histories');
        // Menyalakan kembali pengecekan foreign key constraints setelah drop table selesai
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
