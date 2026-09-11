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
        Schema::create('unit_conversion_details', function (Blueprint $table) {
            $table->id();
            $table->string('unit_conversion_id', 10);
            $table->foreign('unit_conversion_id')->references('id_unit_conversion')->on('unit_conversions')->onDelete('cascade');
            $table->string('unit_id', 15);
            $table->foreign('unit_id')->references('unit_id')->on('units')->onDelete('cascade');
            $table->decimal('conversion_value', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_conversion_details');
    }
};
