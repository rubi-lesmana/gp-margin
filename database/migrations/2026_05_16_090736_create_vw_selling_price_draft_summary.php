<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vw_selling_price_draft_summary AS

            SELECT
                item_id,
                description,
                id_cost_price,
                cost_price_date,
                cost_price_snapshot,
                market_price_snapshot,
                MIN(suggested_selling_price) AS ssp_min,
                MAX(suggested_selling_price) AS ssp_max

            FROM vw_selling_price_draft

            GROUP BY
                item_id,
                description,
                id_cost_price,
                cost_price_date,
                cost_price_snapshot,
                market_price_snapshot

            ORDER BY cost_price_date DESC, item_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_selling_price_draft_summary");
    }
};