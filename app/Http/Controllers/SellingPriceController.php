<?php

namespace App\Http\Controllers;

use App\Models\SellingPrice;
use App\Models\SellingPriceDetail;
use App\Models\SellingPriceDraft;
use App\Services\PricingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellingPriceController extends Controller
{
    public function __construct(
        private readonly PricingService $pricingService
    ) {}

    /**
     * Index — gabungkan draft (dari view) + approved (dari tabel)
     * dalam satu tabel, dibedakan kolom status.
     */
    public function index(Request $request)
    {
        // ── DRAFT — dari vw_selling_price_draft_summary ───────────
        $drafts = DB::table('vw_selling_price_draft_summary')
            ->select([
                DB::raw("'draft' as source"),
                'item_id',
                'description',
                'id_cost_price',
                'cost_price_date',
                'cost_price_snapshot',
                'market_price_snapshot',
                'ssp_min',
                'ssp_max',
                DB::raw("'draft' as status"),
                DB::raw("NULL as id_selling_price"),
                DB::raw("NULL as approved_at"),
                DB::raw("NULL as approved_by_name"),
            ]);

        // ── APPROVED — dari tabel selling_prices ──────────────────
        $approved = DB::table('selling_prices as sp')
            ->join('item as i', 'i.item_id', '=', 'sp.item_id')
            ->join('cost_prices as cp', 'cp.id_cost_price', '=', 'sp.cost_price_id')
            ->join('users as u', 'u.id', '=', 'sp.approved_by')
            ->leftJoin('selling_price_details as spd', 'spd.selling_price_id', '=', 'sp.id_selling_price')
            ->select([
                DB::raw("'approved' as source"),
                'sp.item_id',
                'i.description',
                'sp.cost_price_id as id_cost_price',
                'cp.date as cost_price_date',
                'sp.cost_price_snapshot',
                'sp.market_price_snapshot',
                DB::raw('MIN(spd.suggested_selling_price) as ssp_min'),
                DB::raw('MAX(spd.suggested_selling_price) as ssp_max'),
                'sp.status',
                'sp.id_selling_price',
                'sp.approved_at',
                'u.name as approved_by_name',
            ])
            ->whereIn('sp.status', ['approved', 'superseded'])
            ->groupBy(
                'sp.item_id', 'i.description',
                'sp.cost_price_id', 'cp.date',
                'sp.cost_price_snapshot', 'sp.market_price_snapshot',
                'sp.status', 'sp.id_selling_price',
                'sp.approved_at', 'u.name',
            );

        // ── UNION + FILTER ────────────────────────────────────────
        $list = $drafts->unionAll($approved);

        $results = DB::table(DB::raw("({$list->toSql()}) as combined"))
            ->mergeBindings($list)
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('item_id', 'like', "%{$request->search}%")
                      ->orWhere('description', 'like', "%{$request->search}%");
                });
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->orderByRaw("FIELD(status, 'draft', 'approved', 'superseded')")
            ->orderBy('item_id')
            ->paginate(10)
            ->withQueryString();

        return view('transaction.sellingprice.index', compact('results'));
    }

    /**
     * Show — satu halaman untuk draft dan approved.
     * Bedanya hanya di tombol action (approve vs read only).
     */
    public function show(string $itemId, string $costPriceId, ?string $sellingPriceId = null)
    {
        $isDraft = is_null($sellingPriceId);

        if ($isDraft) {
            // ── Source: view draft ────────────────────────────────
            $exists = SellingPriceDraft::where('item_id', $itemId)
                ->where('id_cost_price', $costPriceId)
                ->exists();

            abort_if(!$exists, 404, 'Draft tidak ditemukan.');

            $header  = SellingPriceDraft::where('item_id', $itemId)
                ->where('id_cost_price', $costPriceId)
                ->first();

            $details = SellingPriceDraft::where('item_id', $itemId)
                ->where('id_cost_price', $costPriceId)
                ->orderBy('adj_gp_margin_price')
                ->orderBy('top_days_snapshot')
                ->get();

        } else {
            // ── Source: tabel selling_prices ──────────────────────
            $spHeader = SellingPrice::with(['item', 'approvedByUser', 'costPrice'])
                ->findOrFail($sellingPriceId);

            // Map ke struktur yang sama dengan draft
            // agar blade tidak perlu kondisi berbeda
            $header = (object) [
                'item_id'               => $spHeader->item_id,
                'description'           => $spHeader->item->description,
                'id_cost_price'         => $spHeader->cost_price_id,
                'cost_price_date'       => $spHeader->costPrice->date,
                'cost_price_snapshot'   => $spHeader->cost_price_snapshot,
                'market_price_snapshot' => $spHeader->market_price_snapshot,
                'approved_at'           => $spHeader->approved_at,
                'approved_by_name'      => $spHeader->approvedByUser->name,
                'status'                => $spHeader->status,
            ];

            $details = SellingPriceDetail::where('selling_price_id', $sellingPriceId)
                ->orderBy('adj_gp_margin_price')
                ->orderBy('top_days_snapshot')
                ->get();
        }

        $detailsByCategory = $details->groupBy('category_status');
        $sspMin = $details->min('suggested_selling_price');
        $sspMax = $details->max('suggested_selling_price');

        return view('transaction.sellingprice.show', compact(
            'header', 'detailsByCategory', 'sspMin', 'sspMax',
            'isDraft', 'itemId', 'costPriceId', 'sellingPriceId'
        ));
    }

    /**
     * Approve — store semua kombinasi item ke tabel permanen.
     */
    public function approve(string $itemId, string $costPriceId, Request $request)
    {
        try {
            $this->pricingService->store(
                itemId      : $itemId,
                costPriceId : $costPriceId,
                approvedBy  : $request->user()->id,
            );

            return redirect()
                ->route('selling-price.index')
                ->with('success', "SSP item {$itemId} berhasil diapprove.");

        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}