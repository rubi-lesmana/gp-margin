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
        Schema::create('sales_proposal_details', function (Blueprint $table) {
            $table->id();
            $table->string('proposal_id', 30);
            $table->foreign('proposal_id')
                ->references('id_proposal')
                ->on('sales_proposals')
                ->onDelete('cascade');

            $table->string('item_id', 25);
            $table->foreign('item_id')->references('item_id')->on('item');

            $table->string('selling_price_id', 50);
            $table->foreign('selling_price_id')
                ->references('id_selling_price')
                ->on('selling_prices');

            $table->decimal('qty', 15, 4)->default(1)
                ->comment('Jumlah unit yang diajukan');

            $table->decimal('ssp_min_snapshot', 15, 2);
            $table->decimal('ssp_max_snapshot', 15, 2);
            $table->decimal('proposed_price', 15, 2);
            $table->decimal('price_diff', 15, 2);
            $table->decimal('price_diff_pct', 8, 4);

            $table->enum('price_position', [
                'above_max',
                'at_max',
                'between',
                'below_min',
            ]);

            $table->boolean('is_below_ssp')->default(false);

            $table->timestamps();

            $table->unique(['proposal_id', 'item_id'], 'uq_spd_proposal_item');
            $table->index(['item_id', 'proposal_id'],  'idx_spd_item');
            $table->index(['is_below_ssp'],            'idx_spd_below_ssp');
            $table->index(['price_position'],          'idx_spd_price_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_proposal_details');
    }
};