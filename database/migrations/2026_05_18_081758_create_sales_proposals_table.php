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
        Schema::create('sales_proposals', function (Blueprint $table) {
            $table->string('id_proposal', 30)->primary();

            // Entitas terkait
            $table->string('customer_id');
            $table->foreign('customer_id')->references('id_customer')->on('customers');

            $table->string('item_id', 25);
            $table->foreign('item_id')->references('item_id')->on('item');

            $table->string('selling_price_id', 50);
            $table->foreign('selling_price_id')->references('id_selling_price')->on('selling_prices');

            // ── SNAPSHOT HARGA ───────────────────────────────────────────
            $table->decimal('ssp_min_snapshot', 15, 2)
                ->comment('Salin SSP Min saat pengajuan dibuat — immutable');
            $table->decimal('ssp_max_snapshot', 15, 2)
                ->comment('Salin SSP Max saat pengajuan dibuat — immutable');
            $table->decimal('proposed_price', 15, 2)
                ->comment('Harga yang diajukan sales');

            // ── SELISIH VS SSP MAX ───────────────────────────────────────
            $table->decimal('price_diff', 15, 2)
                ->comment('proposed_price - ssp_max_snapshot. Negatif = di bawah SSP Max');
            $table->decimal('price_diff_pct', 8, 4)
                ->comment('(price_diff / ssp_max_snapshot) × 100. Negatif = di bawah SSP Max');

            // ── STATUS POSISI HARGA ──────────────────────────────────────
            $table->enum('price_position', [
                'above_max',    // proposed_price > ssp_max_snapshot
                'at_max',       // proposed_price = ssp_max_snapshot
                'between',      // ssp_min_snapshot <= proposed_price < ssp_max_snapshot
                'below_min',    // proposed_price < ssp_min_snapshot
            ])->comment('Posisi harga pengajuan relatif terhadap SSP Min & Max');

            $table->boolean('is_below_ssp')->default(false)
                ->comment('true jika proposed_price < ssp_max_snapshot');

            // ── STATUS APPROVAL ──────────────────────────────────────────
            $table->enum('status', [
                'approved',
                'pending_approval',
                'rejected',
            ])->default('pending_approval');

            // ── AUDIT ────────────────────────────────────────────────────
            $table->foreignId('submitted_by')->constrained('users');
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->text('rejection_note')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->index(['item_id', 'status', 'submitted_at'],     'idx_sp_item_status');
            $table->index(['customer_id', 'status', 'submitted_at'], 'idx_sp_customer_status');
            $table->index(['submitted_by', 'status'],                'idx_sp_sales_status');
            $table->index(['is_below_ssp', 'status'],                'idx_sp_below_ssp');
            $table->index(['price_position'],                        'idx_sp_price_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_proposals');
    }
};