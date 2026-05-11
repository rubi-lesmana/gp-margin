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
        Schema::table('item', function (Blueprint $table) {
            // Penambahan kolom unit_id dengan foreign key ke tabel units
            $table->string('unit_id', 15)->after('base_margin_id')->nullable();
            $table->foreign('unit_id')->references('unit_id')->on('units')->onDelete('set null');
            // Penambahan kolom id pareto dengan foreign key ke tabel pareto
            $table->unsignedBigInteger('pareto_id')->after('unit_id')->nullable();
            $table->foreign('pareto_id')->references('id')->on('paretos')->onDelete('set null'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');
            $table->dropForeign(['pareto_id']);
            $table->dropColumn('pareto_id');
        });
    }
};