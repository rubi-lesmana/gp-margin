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
        Schema::create('suggests', function (Blueprint $table) {
            $table->string('id_suggest', 7)->primary();
            $table->string('item_id');
            $table->foreign('item_id')->references('item_id')->on('item')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('cost_price', 10, 2);
            $table->integer('top');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggests');
    }
};
