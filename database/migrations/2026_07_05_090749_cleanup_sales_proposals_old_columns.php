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
        Schema::table('sales_proposals', function (Blueprint $table) {
            // Drop foreign key dulu sebelum drop kolom
            $table->dropForeign(['item_id']);
            $table->dropForeign(['selling_price_id']);

            $table->dropIndex('idx_sp_item_status');
            $table->dropIndex('idx_sp_below_ssp');
            $table->dropIndex('idx_sp_price_position');

            $table->dropColumn([
                'item_id',
                'selling_price_id',
                'ssp_min_snapshot',
                'ssp_max_snapshot',
                'proposed_price',
                'price_diff',
                'price_diff_pct',
                'price_position',
                'is_below_ssp',
            ]);
        });

        // Setelah data migrasi selesai, jadikan top_id NOT NULL
        Schema::table('sales_proposals', function (Blueprint $table) {
            $table->unsignedBigInteger('top_id')->nullable(false)->change();
            $table->unsignedSmallInteger('top_days_snapshot')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan kolom lama jika rollback
        Schema::table('sales_proposals', function (Blueprint $table) {
            $table->string('item_id', 25)->nullable();
            $table->string('selling_price_id', 50)->nullable();
            $table->decimal('ssp_min_snapshot', 15, 2)->nullable();
            $table->decimal('ssp_max_snapshot', 15, 2)->nullable();
            $table->decimal('proposed_price', 15, 2)->nullable();
            $table->decimal('price_diff', 15, 2)->nullable();
            $table->decimal('price_diff_pct', 8, 4)->nullable();
            $table->enum('price_position', ['above_max','at_max','between','below_min'])->nullable();
            $table->boolean('is_below_ssp')->default(false);

            $table->unsignedBigInteger('top_id')->nullable()->change();
            $table->unsignedSmallInteger('top_days_snapshot')->nullable()->change();
        });
    }
};