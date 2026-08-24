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
        Schema::table('arrival', function (Blueprint $table) {
            // Pindahkan 'date' ke posisi setelah 'item_id'
            $table->date('date')->after('item_id')->change();

            // Pindahkan 'keterangan' ke posisi setelah 'date'
            $table->string('keterangan', 50)->nullable()->default('text')->after('date')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arrival', function (Blueprint $table) {
            // Kembalikan urutan seperti semula (setelah quantity)
            $table->date('date')->after('quantity')->change();
            $table->string('keterangan', 50)->nullable()->default('text')->after('date')->change();

        });
    }
};

