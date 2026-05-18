<?php

// app/Http/Controllers/SalesProposalController.php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\SalesProposal;
use App\Models\SellingPrice;
use App\Models\SellingPriceDetail;
use App\Services\SalesProposalService;
use App\Traits\HasPricingPercentage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesProposalController extends Controller
{

    use HasPricingPercentage;
    public function __construct(
        private readonly SalesProposalService $service
    ) {}

    /**
     * Index — list semua pengajuan.
     * Sales hanya lihat miliknya sendiri.
     * Manager lihat semua + filter pending.
     */
    public function index(Request $request)
    {
        $proposals = SalesProposal::with(['customer', 'item', 'submittedBy'])
            ->when(auth()->user()->role !== 'admin', function ($q) {
                // Sales hanya lihat pengajuan miliknya
                $q->where('submitted_by', auth()->id());
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->whereHas('item', fn($q) =>
                        $q->where('item_id', 'like', "%{$request->search}%")
                          ->orWhere('description', 'like', "%{$request->search}%")
                    )->orWhereHas('customer', fn($q) =>
                        $q->where('name', 'like', "%{$request->search}%")
                    );
                });
            })
            ->orderByRaw("FIELD(status, 'pending_approval', 'approved', 'manager_approved', 'rejected')")
            ->orderBy('submitted_at', 'desc')
            ->get();

        return view('transaction.proposal.index', compact('proposals'));
    }

    /**
     * Create — form pengajuan harga.
     */
    public function create()
    {
        $customers = Customer::pluck('name', 'id_customer');
        $items     = Item::whereHas('sellingPrices', fn($q) =>
                        $q->where('status', 'approved')
                     )->orderBy('item_id')->get();

        return view('transaction.proposal.create', compact('customers', 'items'));
    }

    /**
     * Store — submit pengajuan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'    => 'required|exists:customers,id_customer',
            'item_id'        => 'required|exists:item,item_id',
            'proposed_price' => 'required|numeric|min:1',
        ]);

        try {
            $proposal = $this->service->submit(
                customerId    : $request->customer_id,
                itemId        : $request->item_id,
                proposedPrice : (float) $request->proposed_price,
                submittedBy   : Auth::id(),
            );

            $message = $proposal->is_below_ssp
                ? "Pengajuan {$proposal->id_proposal} berhasil disubmit. Menunggu approval manager karena harga di bawah SSP."
                : "Pengajuan {$proposal->id_proposal} berhasil disubmit dan otomatis diapprove.";

            return redirect()
                ->route('proposal.index')
                ->with('success', $message);

        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show — detail pengajuan.
     */
    public function show(string $proposalId)
    {
        $proposal = SalesProposal::with([
            'customer', 'item', 'sellingPrice',
            'submittedBy', 'reviewedBy'
        ])->findOrFail($proposalId);

        // SSP detail untuk referensi
        $sspDetails = SellingPriceDetail::where('selling_price_id', $proposal->selling_price_id)
            ->orderBy('category_status')
            ->orderBy('top_days_snapshot')
            ->get();

        return view('transaction.proposal.show', compact('proposal', 'sspDetails'));
    }

    /**
     * Approve — manager approve pengajuan di bawah SSP.
     */
    public function approve(string $proposalId)
    {
        // abort_if(auth()->user()->role === 'admin', 403);
        try {
            $this->service->approve($proposalId, Auth::id());

            return redirect()
                ->route('proposal.index')
                ->with('success', "Pengajuan {$proposalId} berhasil diapprove.");

        } catch (\Throwable $e) {
            // return redirect()->back()->with('error', $e->getMessage());
             dd([
                'error_class'   => get_class($e),
                'error_message' => $e->getMessage(),
                'error_line'    => $e->getLine(),
                'error_file'    => $e->getFile(),
            ]);
        }
    }

    /**
     * Reject — manager reject pengajuan di bawah SSP.
     */
    public function reject(Request $request, string $proposalId)
    {
        $request->validate([
            'rejection_note' => 'required|string|min:10',
        ]);

        try {
            $this->service->reject($proposalId, Auth::id(), $request->rejection_note);

            return redirect()
                ->route('proposal.index')
                ->with('success', "Pengajuan {$proposalId} ditolak.");

        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get SSP info untuk item — dipakai AJAX saat sales pilih item.
     */
    public function getSspInfo(string $itemId)
    {
        $sellingPrice = SellingPrice::where('item_id', $itemId)
            ->where('status', 'approved')
            ->latest('approved_at')
            ->first();

        if (!$sellingPrice) {
            return response()->json([
                'ssp_min' => null,
                'ssp_max' => null,
                'message' => 'Belum ada SSP untuk item ini.',
            ]);
        }

        $sspMin = SellingPriceDetail::where('selling_price_id', $sellingPrice->id_selling_price)
            ->min('suggested_selling_price');

        $sspMax = SellingPriceDetail::where('selling_price_id', $sellingPrice->id_selling_price)
            ->max('suggested_selling_price');

        return response()->json([
            'ssp_min'           => $sspMin,
            'ssp_min_formatted' => number_format($sspMin, 2),
            'ssp_max'           => $sspMax,
            'ssp_max_formatted' => number_format($sspMax, 2),
            'selling_price_id'  => $sellingPrice->id_selling_price,
            'approved_at'       => $sellingPrice->approved_at->format('d M Y'),
        ]);
    }
}