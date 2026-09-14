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
            $table->string('unit_conversion_id', 10)->nullable()->after('unit_id');
            $table->foreign('unit_conversion_id')->references('id_unit_conversion')->on('unit_conversions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item', function (Blueprint $table) {
            $table->dropForeign(['unit_conversion_id']);
            $table->dropColumn('unit_conversion_id');
        });
    }
};

