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
        Schema::create('cost_prices', function (Blueprint $table) {
            $table->string('id_cost_price')->primary();
            $table->date('date');
            // Foreign key to arrival
            $table->string('arrival_id', 30);
            $table->foreign('arrival_id')->references('id')->on('arrival')->onDelete('cascade');
            // Foreign key to item
            $table->string('item_id', 25);
            $table->foreign('item_id')->references('item_id')->on('item')->onDelete('cascade');
            $table->decimal('cost_price', 15, 2);
            $table->string('manual_reference', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_prices');
    }
};