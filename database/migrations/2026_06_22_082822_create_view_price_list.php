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
        DB:: statement("
            CREATE OR REPLACE VIEW view_price_list AS
            SELECT 
                i.item_id,
                i.description,
                sp.id_selling_price,
                sp.cost_price_snapshot,
                sp.market_price_snapshot,
                sp.approved_at,
                sp.status,
                u.name AS approved_by_name,
                cp.date AS cost_price_date,
                MIN(spd.suggested_selling_price) AS ssp_min,
                MAX(spd.suggested_selling_price) AS ssp_max
            FROM 
                item i
            LEFT JOIN 
                selling_prices sp ON sp.item_id = i.item_id AND sp.status = 'approved'
            LEFT JOIN 
                selling_price_details spd ON spd.selling_price_id = sp.id_selling_price
            LEFT JOIN 
                cost_prices cp ON cp.id_cost_price = sp.cost_price_id
            LEFT JOIN 
                users u ON u.id = sp.approved_by
            GROUP BY 
                i.item_id,
                i.description,
                sp.id_selling_price,
                sp.cost_price_snapshot,
                sp.market_price_snapshot,
                sp.approved_at,
                sp.status,
                u.name,
                cp.date;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_price_list');
    }
};