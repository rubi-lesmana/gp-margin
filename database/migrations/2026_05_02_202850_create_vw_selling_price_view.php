<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_selling_price AS
            SELECT
                i.item_id,
                i.description,
                bm.margin_percentage,
                c.status AS category_status,
                c.calculation,
                ROUND(bm.margin_percentage * c.calculation, 4) AS gp_margin,

                top.id AS top_id,
                top.description AS top_description,
                top.days,
                tgp.margin_percentage AS top_margin_pct,

                ROUND(
                    (top.days / 365.0 / NULLIF(tgp.margin_percentage *  100, 0))
                    + (bm.margin_percentage * c.calculation)
                , 4) AS target_gp

            FROM item i
            INNER JOIN base_margin bm  ON bm.id  = i.base_margin_id
            CROSS JOIN categories c
            CROSS JOIN term_of_payments top
            INNER JOIN tgp_margins tgp ON tgp.id = top.percent_id

            ORDER BY i.item_id, c.status, top.days;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vw_selling_price_view');
    }
};