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
        Schema::create('market_price_details', function (Blueprint $table) {
            $table->id();
            $table->string('market_price_id', 25);
            $table->foreign('market_price_id')->references('id_market_price')->on('market_price')->onDelete('cascade');
            $table->string('item_id', 25);
            $table->foreign('item_id')->references('item_id')->on('item')->onDelete('cascade');
            $table->decimal('price', 15, 2)->nullable()->default(123.45);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_price_details');
    }
};