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
            CREATE VIEW view_sales_proposal_exports AS
            SELECT
                a.id_proposal,
                a.status,
                c.name              AS cust_name,
                d.days,
                d.description       AS top_description,
                b.item_id,
                e.description       AS item_description,
                b.selling_price_id,
                b.qty                AS qty_kg,
                b.proposed_price,
                b.ssp_min_snapshot   AS minimum_price,
                b.ssp_max_snapshot   AS maximum_price,
                b.price_diff,
                CASE
                    WHEN b.ssp_min_snapshot IS NULL OR b.ssp_min_snapshot = 0 THEN NULL
                    ELSE ROUND(
                        (b.proposed_price - b.ssp_min_snapshot) / b.ssp_min_snapshot * 100,
                        2
                    )
                END AS price_diff_pct,
                b.price_position,
                b.is_below_ssp
            FROM sales_proposals a
            JOIN sales_proposal_details b ON a.id_proposal = b.proposal_id
            JOIN customers c              ON a.customer_id = c.id_customer
            JOIN term_of_payments d       ON a.top_id = d.id
            JOIN item e                   ON b.item_id = e.item_id
            ORDER BY a.id_proposal ASC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_sales_proposal_exports');
    }
};