<?php

namespace App\Http\Controllers;

use App\Models\SellingPriceDraft;
use App\Services\PricingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellingPriceController extends Controller
{
    // ── Inject PricingService via constructor ─────────────────────
    public function __construct(
        private readonly PricingService $pricingService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $drafts = DB::table('vw_selling_price_draft_summary')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('item_id', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
                });
            })
            ->paginate(5);

        return view('transaction.sellingprice.index', compact('drafts'));
    }

    /**
     * Show — breakdown lengkap semua kombinasi category × TOP untuk satu item.
     * Supervisor review di sini sebelum approve.
     */
    public function show(string $itemId, string $costPriceId)
    {
        $exists = SellingPriceDraft::where('item_id', $itemId)
            ->where('id_cost_price', $costPriceId)
            ->exists();

        abort_if(! $exists, 404, 'Draft tidak ditemukan.');

        $header = SellingPriceDraft::where('item_id', $itemId)
            ->where('id_cost_price', $costPriceId)
            ->first();

        $details = SellingPriceDraft::where('item_id', $itemId)
            ->where('id_cost_price', $costPriceId)
            ->orderBy('category_status')
            ->orderBy('top_days_snapshot')
            ->get();

        $detailsByCategory = $details->groupBy('category_status');
        $sspMin = $details->min('suggested_selling_price');
        $sspMax = $details->max('suggested_selling_price');

        return view('transaction.sellingprice.show', compact(
            'header', 'detailsByCategory', 'sspMin', 'sspMax'
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
            // dd([
            //     'error_class'   => get_class($e),
            //     'error_message' => $e->getMessage(),
            //     'error_line'    => $e->getLine(),
            //     'error_file'    => $e->getFile(),
            // ]);
        }
    }
}