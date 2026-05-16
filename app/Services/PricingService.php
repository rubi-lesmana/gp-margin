<?php

// app/Services/PricingService.php

namespace App\Services;

use App\Models\SellingPrice;
use App\Models\SellingPriceDetail;
use App\Models\SellingPriceDraft;
use Illuminate\Support\Facades\DB;

class PricingService
{
    public function store(string $itemId, string $costPriceId, int $approvedBy): void
    {
        // Ambil semua kombinasi dari view untuk item + cost price ini
        $drafts = SellingPriceDraft::where('item_id', $itemId)
            ->where('id_cost_price', $costPriceId)
            ->orderBy('category_status')
            ->orderBy('top_days_snapshot')
            ->get();

        // Guard: pastikan draft masih ada di view
        if ($drafts->isEmpty()) {
            throw new \RuntimeException(
                "Draft tidak ditemukan untuk item {$itemId}. " .
                "Kemungkinan sudah di-approve sebelumnya."
            );
        }

        DB::transaction(function () use ($drafts, $itemId, $costPriceId, $approvedBy) {

            $first = $drafts->first();
            $now   = now();

            // ── STEP 1: Supersede selling price lama ─────────────────────
            SellingPrice::where('item_id', $itemId)
                ->where('status', 'approved')
                ->update(['status' => 'superseded']);

            // ── STEP 2: Generate ID selling price ────────────────────────
            $sequence = str_pad(
                SellingPrice::whereDate('created_at', today())->count() + 1,
                3, '0', STR_PAD_LEFT
            );
            $sellingPriceId = 'SP-' . $sequence;

            // ── STEP 3: Insert header selling_prices ─────────────────────
            SellingPrice::create([
                'id_selling_price'       => $sellingPriceId,
                'item_id'                => $itemId,
                'cost_price_id'          => $costPriceId,
                'cost_price_snapshot'    => $first->cost_price_snapshot,
                'market_price_detail_id' => $first->market_price_detail_id,
                'market_price_snapshot'  => $first->market_price_snapshot,
                'status'                 => 'approved',
                'calculated_by'          => $approvedBy,
                'approved_by'            => $approvedBy,
                'calculated_at'          => $now,
                'approved_at'            => $now,
            ]);

            // ── STEP 4: Bulk insert detail ────────────────────────────────
            $details = $drafts->map(fn($draft) => [
                'selling_price_id'        => $sellingPriceId,
                'base_margin_id'          => $draft->base_margin_id,
                'base_margin_snapshot'    => $draft->base_margin_snapshot,
                'category_status'         => $draft->category_status,
                'category_calc_snapshot'  => $draft->category_calc_snapshot,
                'gp_margin'               => $draft->gp_margin,
                'term_of_payment_id'      => $draft->term_of_payment_id,
                'top_days_snapshot'       => $draft->top_days_snapshot,
                'tgp_margin_id'           => $draft->tgp_margin_id,
                'top_pct_snapshot'        => $draft->top_pct_snapshot,
                'target_gp'               => $draft->target_gp,
                'adj_gp_margin_price'     => $draft->adj_gp_margin_price,
                'suggested_selling_price' => $draft->suggested_selling_price,
                'ssp_basis'               => $draft->ssp_basis,
                'status'                  => 'active',
                'created_at'              => $now->toDateTimeString(),
                'updated_at'              => $now->toDateTimeString(),
            ])->toArray();

            SellingPriceDetail::insert($details);
        });
    }
}