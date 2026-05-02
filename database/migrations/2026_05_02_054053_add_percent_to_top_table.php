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
        Schema::table('term_of_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('percent_id')->nullable()->after('description');
            $table->foreign('percent_id')->references('id')->on('tgp_margins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('term_of_payments', function (Blueprint $table) {
            $table->dropForeign(['percent_id']);
            $table->dropColumn('percent_id');
        });
    }
};