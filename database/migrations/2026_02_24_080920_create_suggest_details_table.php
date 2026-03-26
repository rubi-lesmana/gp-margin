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
        Schema::create('suggest_details', function (Blueprint $table) {
            $table->id();
            $table->string('id_suggest', 7);
            $table->foreign('id_suggest')->references('id_suggest')->on('suggests')->onDelete('cascade');
            $table->string('qty_category', 25)->default('text');
            $table->decimal('gp_margin', 5, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggest_details');
    }
};
