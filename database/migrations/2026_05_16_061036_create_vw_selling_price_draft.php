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
            CREATE VIEW vw_selling_price_draft AS

            SELECT
                -- ── IDENTITAS ITEM ─────────────────────────────────────
                i.item_id,
                i.description,

                -- ── COST PRICE ─────────────────────────────────────────
                cp.id_cost_price,
                cp.date             AS cost_price_date,
                cp.cost_price       AS cost_price_snapshot,

                -- ── BASE MARGIN ─────────────────────────────────────────
                bm.id               AS base_margin_id,
                bm.margin_percentage AS base_margin_snapshot,

                -- ── CALCULATION CATEGORY ────────────────────────────────
                cat.status          AS category_status,
                cat.calculation     AS category_calc_snapshot,

                -- ── TERM OF PAYMENT ─────────────────────────────────────
                top.id              AS term_of_payment_id,
                top.days            AS top_days_snapshot,

                -- ── TGP MARGIN ──────────────────────────────────────────
                tgp.id              AS tgp_margin_id,
                tgp.margin_percentage AS top_pct_snapshot,

                -- ── MARKET PRICE (nullable) ──────────────────────────────
                mpd.id              AS market_price_detail_id,
                mpd.price           AS market_price_snapshot,

                -- ── GP MARGIN ───────────────────────────────────────────
                -- base_margin_snapshot × category_calc_snapshot
                ROUND(
                    bm.margin_percentage * cat.calculation
                , 4) AS gp_margin,

                -- ── TARGET GP ───────────────────────────────────────────
                -- (top_days / 365 × top_pct) + gp_margin
                ROUND(
                    (top.days / 365.0 * tgp.margin_percentage)
                    + (bm.margin_percentage * cat.calculation)
                , 4) AS target_gp,

                -- ── ADJ GP MARGIN PRICE ──────────────────────────────────
                -- cost_price + (cost_price × target_gp)
                ROUND(
                    cp.cost_price * (
                        1 + (
                            (top.days / 365.0 * tgp.margin_percentage)
                            + (bm.margin_percentage * cat.calculation)
                        )
                    )
                , 2) AS adj_gp_margin_price,

                -- ── SUGGESTED SELLING PRICE ──────────────────────────────
                -- max(adj_gp_margin_price, market_price)
                -- jika market_price NULL → langsung pakai adj_gp_margin_price
                ROUND(
                    GREATEST(
                        cp.cost_price * (
                            1 + (
                                (top.days / 365.0 * tgp.margin_percentage)
                                + (bm.margin_percentage * cat.calculation)
                            )
                        ),
                        COALESCE(mpd.price, 0)
                    )
                , 2) AS suggested_selling_price,

                -- ── SSP BASIS ────────────────────────────────────────────
                CASE
                    WHEN mpd.price IS NULL
                        THEN 'adj_gp_margin_price'
                    WHEN mpd.price >= ROUND(
                        cp.cost_price * (
                            1 + (
                                (top.days / 365.0 * tgp.margin_percentage)
                                + (bm.margin_percentage * cat.calculation)
                            )
                        ), 2)
                        THEN 'market_price'
                    ELSE 'adj_gp_margin_price'
                END AS ssp_basis

            FROM cost_prices cp

            -- ── JOIN ITEM ────────────────────────────────────────────────
            INNER JOIN item i
                ON i.item_id = cp.item_id

            -- ── JOIN BASE MARGIN via item ────────────────────────────────
            INNER JOIN base_margin bm
                ON bm.id = i.base_margin_id

            -- ── CROSS JOIN CATEGORIES ────────────────────────────────────
            CROSS JOIN categories cat

            -- ── CROSS JOIN TERM OF PAYMENT ───────────────────────────────
            CROSS JOIN term_of_payments top

            -- ── JOIN TGP MARGIN via TOP ──────────────────────────────────
            INNER JOIN tgp_margins tgp
                ON tgp.id = top.percent_id

            -- ── LEFT JOIN MARKET PRICE terbaru per item ──────────────────
            LEFT JOIN market_price_details mpd
                ON  mpd.item_id = cp.item_id
                AND mpd.market_price_id = (
                    SELECT mp2.id_market_price
                    FROM market_price mp2
                    INNER JOIN market_price_details mpd2
                        ON  mpd2.market_price_id = mp2.id_market_price
                        AND mpd2.item_id         = cp.item_id
                    ORDER BY mp2.effective_date DESC
                    LIMIT 1
                )

            -- ── FILTER 1: hanya cost price terbaru per item ──────────────
            WHERE cp.id_cost_price = (
                SELECT cp2.id_cost_price
                FROM cost_prices cp2
                WHERE cp2.item_id = cp.item_id
                ORDER BY cp2.date DESC, cp2.created_at DESC
                LIMIT 1
            )

            -- ── FILTER 2: hanya yang belum punya selling price ───────────
            AND NOT EXISTS (
                SELECT 1
                FROM selling_prices sp
                WHERE sp.cost_price_id = cp.id_cost_price
            )

            ORDER BY i.item_id, cat.status, top.days
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_selling_price_draft");
    }
};