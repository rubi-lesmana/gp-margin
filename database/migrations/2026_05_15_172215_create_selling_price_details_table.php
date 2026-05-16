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
        // Migration 2: selling_price_details (revised)

        Schema::create('selling_price_details', function (Blueprint $table) {
            $table->id();

            $table->string('selling_price_id', 30);
            $table->foreign('selling_price_id')
                ->references('id_selling_price')->on('selling_prices');

            // ── KOMPONEN GP MARGIN ──────────────────────────────────────────
            $table->foreignId('base_margin_id')
                ->constrained('base_margin')
                ->comment('FK trace: pakai record base_margin yang mana');
            $table->decimal('base_margin_snapshot', 8, 4)
                ->comment('Salin dari base_margin.margin_percentage. e.g. 0.0800');

            $table->string('category_status', 15)
                ->comment('FK trace: pakai category mana (Low/High)');
            $table->foreign('category_status')->references('status')->on('categories');
            $table->decimal('category_calc_snapshot', 8, 4)
                ->comment('Salin dari categories.calculation. e.g. 1.2500');

            $table->decimal('gp_margin', 8, 4)
                ->comment('base_margin_snapshot × category_calc_snapshot. e.g. 0.1000');

            // ── KOMPONEN TARGET GP ──────────────────────────────────────────
            $table->foreignId('term_of_payment_id')
                ->constrained('term_of_payments')
                ->comment('FK trace: pakai TOP yang mana');
            $table->smallInteger('top_days_snapshot')
                ->comment('Salin dari term_of_payments.days. e.g. 30');

            $table->foreignId('tgp_margin_id')
                ->constrained('tgp_margins')
                ->comment('FK trace: pakai tgp_margin record yang mana');
            $table->decimal('top_pct_snapshot', 8, 4)
                ->comment('Salin dari tgp_margins.margin_percentage. e.g. 0.0700');

            $table->decimal('target_gp', 8, 4)
                ->comment('(top_days_snapshot/365 × top_pct_snapshot) + gp_margin. e.g. 0.0917');

            // ── HASIL ADJ & SSP ─────────────────────────────────────────────
            $table->decimal('adj_gp_margin_price', 15, 2)
                ->comment('cost_price_snapshot + (cost_price_snapshot × target_gp)');
            $table->decimal('suggested_selling_price', 15, 2)
                ->comment('max(adj_gp_margin_price, market_price_snapshot dari header)');
            $table->enum('ssp_basis', ['adj_gp_margin_price', 'market_price'])
                ->comment('Mana yang lebih tinggi antara adj price vs market price');

            $table->enum('status', ['active', 'superseded'])->default('active');

            $table->timestamps();

            $table->index(['selling_price_id', 'status'], 'idx_spd_header_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selling_price_details');
    }
};