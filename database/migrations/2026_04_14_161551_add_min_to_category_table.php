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
        Schema::table('category', function (Blueprint $table) {
            //Menambahkan kolom 'min' dengan tipe data integer dan default value 0 after status
            $table->integer('min')->default(0)->after('status');

            // Merubah nama kolom 'quantity' menjadi max 
            $table->renameColumn('quantity', 'max');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category', function (Blueprint $table) {
            // Menghapus kolom 'min'
            $table->dropColumn('min');

            // Merubah nama kolom 'max' kembali menjadi quantity
            $table->renameColumn('max', 'quantity');
        });
    }
};