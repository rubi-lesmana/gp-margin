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
        Schema::table('arrival', function (Blueprint $table) {
            $table->string('unit_id', 15)->after('quantity')->nullable();
            $table->decimal('unit_price', 15, 2)->after('unit_id')->default(0);
            $table->decimal('net_amount', 15, 2)->after('unit_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arrival', function (Blueprint $table) {
            $table->dropColumn('unit_id');
            $table->dropColumn('unit_price');
            $table->dropColumn('net_amount');
        });
    }
};