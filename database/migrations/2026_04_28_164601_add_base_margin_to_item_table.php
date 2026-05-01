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
        Schema::table('item', function (Blueprint $table) {
                // Tambahkan kolom base_margin_id sebagai foreign key yang mengacu ke tabel base_margin
                $table->unsignedBigInteger('base_margin_id')->nullable()->after('description');
                // deinisikan foreign key constraint
                $table->foreign('base_margin_id')->references('id')->on('base_margin')->onDelete('set null'); // Jika base_margin dihapus, set base_margin_id menjadi null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu, baru hapus kolomnya
            $table->dropForeign(['base_margin_id']);
            $table->dropColumn('base_margin_id');
        });
    }
};