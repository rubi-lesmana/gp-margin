<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\SalesProposal;
use App\Models\SellingPrice;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── SUMMARY CARDS ─────────────────────────────────────────
        $totalItem = Item::count();

        $totalItemWithSsp = SellingPrice::where('status', 'approved')
            ->distinct('item_id')
            ->count('item_id');

        $totalItemWithoutSsp = $totalItem - $totalItemWithSsp;

        $totalProposal = SalesProposal::count();

        $totalProposalPending = SalesProposal::where('status', 'pending_approval')->count();

        $totalApproved = SalesProposal::whereIn('status', ['approved', 'manager_approved'])->count();

        $totalProposalBelowMin = SalesProposal::where('price_position', 'below_min')->count();

        // ── GP COMPLIANCE ─────────────────────────────────────────
        // Distribusi price_position dari semua pengajuan
        $complianceData = SalesProposal::select('price_position', DB::raw('COUNT(*) as total'))
            ->whereIn('status', ['approved', 'manager_approved'])
            ->groupBy('price_position')
            ->get()
            ->keyBy('price_position');

        $complianceChart = [
            'above_max'  => $complianceData->get('above_max')?->total  ?? 0,
            'at_max'     => $complianceData->get('at_max')?->total     ?? 0,
            'between'    => $complianceData->get('between')?->total    ?? 0,
            'below_min'  => $complianceData->get('below_min')?->total  ?? 0,
        ];

        // Ambil sum negatif dan positif dalam satu kali query ke database
        $priceDiffSum = SalesProposal::where('status', '=', 'approved')
            ->orWhere('status', '=', 'manager_approved')
            ->selectRaw("
                SUM(CASE WHEN price_diff_pct < 0 THEN price_diff_pct ELSE 0 END) as total_negatif,
                SUM(CASE WHEN price_diff_pct > 0 THEN price_diff_pct ELSE 0 END) as total_positif
            ")
            ->first();

        $totalNegatif = number_format($priceDiffSum->total_negatif ?? 0, 2) . '%'; // Hasilnya akan berupa angka minus (misal: -25.5)
        $totalPositif = number_format($priceDiffSum->total_positif ?? 0, 2) . '%';

        $compliancePct = $totalProposal > 0
            ? round((($complianceChart['above_max'] + $complianceChart['at_max'] + $complianceChart['between']) / $totalProposal) * 100, 1)
            : 0;

        // ── ITEM TANPA SSP ────────────────────────────────────────
        $itemsWithoutSsp = Item::leftJoin('selling_prices as sp', function ($join) {
                $join->on('sp.item_id', '=', 'item.item_id')
                     ->where('sp.status', '=', 'approved');
            })
            ->whereNull('sp.id_selling_price')
            ->select('item.item_id', 'item.description')
            ->orderBy('item.item_id')
            ->get();

        // ── ITEM DENGAN SSP ──────────────────
        $itemsWithSsp = DB::table('item as i')
            // Menggunakan join biasa agar hanya menarik item yang sudah approved SSP-nya
            ->join('selling_prices as sp', function ($join) {
                $join->on('sp.item_id', '=', 'i.item_id')
                    ->where('sp.status', '=', 'approved');
            })
            ->join('selling_price_details as spd', 'spd.selling_price_id', '=', 'sp.id_selling_price')
            ->select([
                'i.item_id',
                'i.description',
                DB::raw('MIN(spd.suggested_selling_price) as ssp_min'),
                DB::raw('MAX(spd.suggested_selling_price) as ssp_max'),
            ])
            ->groupBy('i.item_id', 'i.description')
            ->orderBy('sp.id_selling_price', 'desc')
            ->get();

        // ── PENGAJUAN PENDING APPROVAL ────────────────────────────
        $pendingProposals = SalesProposal::with(['customer', 'item', 'submittedBy'])
            ->where('status', 'pending_approval')
            ->orderBy('submitted_at', 'asc')
            ->get();

        // ── TREND PENGAJUAN 6 BULAN TERAKHIR ─────────────────────
        $trendData = SalesProposal::select(
                DB::raw('DATE_FORMAT(submitted_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN price_position = "below_min" THEN 1 ELSE 0 END) as below_min'),
                DB::raw('SUM(CASE WHEN price_position IN ("above_max","at_max","between") THEN 1 ELSE 0 END) as compliant')
            )
            ->where('submitted_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // ── RECENT ACTIVITY ───────────────────────────────────────
        $recentProposals = SalesProposal::with(['customer', 'item', 'submittedBy'])
            ->orderBy('submitted_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalItem',
            'totalItemWithSsp',
            'totalItemWithoutSsp',
            'totalProposal',
            'totalNegatif',
            'totalPositif',
            'totalProposalPending',
            'totalApproved',
            'totalProposalBelowMin',
            'complianceChart',
            'compliancePct',
            'itemsWithSsp',
            'itemsWithoutSsp',
            'pendingProposals',
            'trendData',
            'recentProposals',
        ));
    }
}