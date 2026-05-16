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
        // Migration 1: selling_prices (revised)

        Schema::create('selling_prices', function (Blueprint $table) {
            $table->string('id_selling_price')->primary();

            $table->string('item_id', 25);
            $table->foreign('item_id')->references('item_id')->on('item');

            $table->string('cost_price_id', 255);
            $table->foreign('cost_price_id')->references('id_cost_price')->on('cost_prices');
            $table->decimal('cost_price_snapshot', 15, 2);

            $table->foreignId('market_price_detail_id')->nullable()
                ->constrained('market_price_details');
            $table->decimal('market_price_snapshot', 15, 2)->nullable();

            $table->enum('status', ['approved', 'superseded'])->default('approved');

            // Audit
            $table->foreignId('calculated_by')->constrained('users')
                ->comment('User yang men-trigger store/approve');
            $table->foreignId('approved_by')->constrained('users')
                ->comment('Supervisor yang approve');
            $table->timestamp('calculated_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->index(['item_id', 'status', 'calculated_at'], 'idx_sp_item_status_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selling_price');
    }
};