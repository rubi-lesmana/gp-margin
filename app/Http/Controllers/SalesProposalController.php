<?php

// app/Http/Controllers/SalesProposalController.php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\SalesProposal;
use App\Models\SellingPrice;
use App\Models\SellingPriceDetail;
use App\Models\TermOfPayment;
use App\Services\SalesProposalService;
use App\Traits\HasPricingPercentage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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
    public function index()
    {
        $proposals = SalesProposal::with(['customer', 'sales_proposal_details',  'term_of_payment','submittedBy'])
            ->withSum('sales_proposal_details', 'proposed_price')
            ->withSum('sales_proposal_details', 'price_diff')
            ->when(auth()->user()->role !== 'admin', fn($q) =>
                $q->where('submitted_by', auth()->id())
            )
            ->orderBy('id_proposal', 'desc')
            ->get();

        return view('transaction.proposal.index', compact('proposals'));
    }

    /**
     * Create — form pengajuan harga.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->pluck('name', 'id_customer');

        $items = Item::whereHas('sellingPrices', fn($q) =>
                    $q->where('status', 'approved')
                )->orderBy('item_id')->get();

        $tops = TermOfPayment::orderBy('days')->pluck('days', 'id');

        return view('transaction.proposal.create.index', compact('customers', 'items', 'tops'));
    }

    /**
     * Store — submit pengajuan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'              => 'required|exists:customers,id_customer',
            'top_id'                   => 'required|exists:term_of_payments,id',
            'items'                    => 'required|array|min:1',
            'items.*.item_id'          => 'required|exists:item,item_id|distinct',
            'items.*.selling_price_id' => 'required|exists:selling_prices,id_selling_price',
            'items.*.qty'              => 'required|numeric|min:0.0001',
            'items.*.proposed_price'   => 'required|numeric|min:1',
        ]);

        try {
            $result = $this->service->submit($request->only([
                'customer_id', 'top_id', 'items',
            ]));

            $idProposal = $result['proposal']->id_proposal;

            Alert::success('Success', $result['hasBelow']
                ? "Submission {$idProposal} has been successfully submitted. Awaiting manager approval due to prices below SSP."
                : "Submission {$idProposal} has been successfully submitted and automatically approved."
            );

            return redirect()->route('proposal.index');

        } catch (\Throwable $e) {
            Alert::error('Error', 'Failed to save proposal: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    
    /**
     * Show — detail pengajuan.
     */
    public function show(string $proposalId)
    {
        $proposal = SalesProposal::with([
            'customer',
            'submittedBy',
            'reviewedBy',
            'term_of_payment',
            'sales_proposal_details.item',
            'sales_proposal_details.selling_price.details',
        ])->findOrFail($proposalId);

        // Ambil semua selling_price_id dari detail proposal
        $sellingPriceIds = $proposal->sales_proposal_details
            ->pluck('selling_price_id')
            ->filter()
            ->unique()
            ->values();

        // Get selling price details, group by selling_price_id lalu by category_status
        $sspDetails = SellingPriceDetail::whereIn('selling_price_id', $sellingPriceIds)
            ->orderByRaw("FIELD(category_status, 'High', 'Medium', 'Low')")
            ->orderBy('top_days_snapshot')
            ->get()
            ->groupBy(['selling_price_id', 'category_status']);


        return view('transaction.proposal.show.index', compact('proposal', 'sspDetails'));

    }

    public function edit(string $proposalId)
    {
        $proposal = SalesProposal::with([
            'customer',
            'submittedBy',
            'reviewedBy',
            'term_of_payment',
            'sales_proposal_details.item',
            'sales_proposal_details.selling_price.details',
        ])->findOrFail($proposalId);

        $customers = Customer::orderBy('name')->pluck('name', 'id_customer');

        $items = Item::whereHas('sellingPrices', fn($q) =>
                    $q->where('status', 'approved')
                )->orderBy('item_id')->get();

        $tops = TermOfPayment::orderBy('days')->pluck('days', 'id');

        return view('transaction.proposal.update.index', compact('proposal', 'customers', 'items', 'tops'));
    }

    public function update(Request $request, string $proposalId)
    {
        $proposal = SalesProposal::findOrFail($proposalId);
        $request->validate([
            'customer_id'              => 'required|exists:customers,id_customer',
            'top_id'                   => 'required|exists:term_of_payments,id',
            'items'                    => 'required|array|min:1',
            'items.*.item_id'          => 'required|exists:item,item_id|distinct',
            'items.*.selling_price_id' => 'required|exists:selling_prices,id_selling_price',
            'items.*.qty'              => 'required|numeric|min:0.0001',
            'items.*.proposed_price'   => 'required|numeric|min:1',
        ]);

        try {
            $result = $this->service->update($proposal, $request->only([
                'customer_id', 'top_id', 'items',
            ]));

            Alert::success('Success', $result['hasBelow']
                ? "Submission {$proposalId} has been successfully updated. Awaiting manager approval due to prices below SSP."
                : "Submission {$proposalId} has been successfully updated and automatically approved."
            );

            return redirect()->route('proposal.index');

        } catch (\Throwable $e) {
            Alert::error('Error', 'Failed to update proposal: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
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