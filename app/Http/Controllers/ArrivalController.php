<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArrivalRequest;
use App\Models\Arrival;
use App\Models\ArrivalStatus;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Supplier;
use App\Services\ArrivalService;
use RealRashid\SweetAlert\Facades\Alert;

class ArrivalController extends Controller
{
    protected ArrivalService $arrivalService;

    public function __construct(ArrivalService $arrivalService)
    {
        $this->arrivalService = $arrivalService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Arrival::with('item')
            ->withCount('cost_price')
            ->orderBy('id', 'desc')
            ->get();
        return view('transaction.arrival.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get data Item with unit 
        $items      = Item::with('unit')->get();

        // Pluck data item_id dan description untuk dropdown select
        $item       = $items->pluck('description', 'item_id')->toArray();

        // Dropdown select untuk status arrival
        $arrivalStatuses = ArrivalStatus::pluck('description', 'code')->toArray();
        // Dropdown Supplier
        $suppliers = Supplier::pluck('supplier_name', 'id_supplier')->toArray();
        // Dropdown Currency
        $currency = Currency::pluck('description', 'id_currency')->toArray();
        // Status Default Currency
        $defaultCurrency = ArrivalStatus::pluck('default_currency_id', 'code')->toArray();
        
        return view('transaction.arrival.create', compact('item', 'arrivalStatuses', 'currency', 'defaultCurrency', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArrivalRequest $request)
    {
        $this->arrivalService->create($request->validated());

        Alert::success('Success', 'Inventory Arrival created successfully');
        return redirect()->route('arrival-inventory.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $arrival = Arrival::with('item.unit_conversion.details.unit', 'supplier', 'currency')->findOrFail($id);
        return view('transaction.arrival.show', compact('arrival'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $arrival = Arrival::with('item.unit_conversion.details.unit', 'cost_price', 'supplier', 'currency')
                    ->withCount('cost_price')
                    ->findOrFail($id);

        // Pengecekan apakah arrival ini sudah memiliki cost price, jika sudah maka tidak bisa diedit
        if ($arrival->cost_price_count > 0) {
            $costPriceId = $arrival->cost_price->id_cost_price;
            Alert::warning('Warning', "This Inventory Arrival has associated Cost Price : { $costPriceId } and cannot be edited.");
            return redirect()->route('arrival-inventory.index');
        }

        // Daftar item untuk dropdown (item_id tidak bisa diubah, tapi tetap ditampilkan)
        $items = Item::all();
        $item  = $items->pluck('description', 'item_id')->toArray();

        // Daftar unit yang valid untuk item yang sudah tersimpan di arrival ini,
        // dipakai untuk populate + preselect dropdown unit saat halaman dimuat
        $unitOptions = optional($arrival->item->unit_conversion)->details->map(function ($d) {
            return [
                'id'    => $d->unit->unit_id ?? $d->unit_id, // kode unit, contoh "Zak"
                'label' => $d->unit->description ?? $d->unit_id,
            ];
        }) ?? collect();

        $arrivalStatuses = ArrivalStatus::pluck('description', 'code')->toArray();
        $suppliers       = Supplier::pluck('supplier_name', 'id_supplier')->toArray();
        $currency        = Currency::pluck('description', 'id_currency')->toArray();
        $defaultCurrency = ArrivalStatus::pluck('default_currency_id', 'code')->toArray();

        return view('transaction.arrival.update', compact(
            'arrival', 'item', 'unitOptions', 'arrivalStatuses', 'currency', 'defaultCurrency', 'suppliers'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArrivalRequest $request, string $id)
    {
        $arrival = Arrival::findOrFail($id);
        $this->arrivalService->update($arrival, $request->validated());
        Alert::success('Success', 'Inventory Arrival updated successfully');
        return redirect()->route('transaction.arrival.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $arrival = Arrival::findOrFail($id);

        if ($arrival->cost_price_count > 0) {
            Alert::error('Error', 'Inventory Arrival cannot be deleted because it has associated Cost Price.');
            return redirect()->route('arrival-inventory.index');
        }
        $arrival->delete();

        Alert::success('Success', 'Inventory Arrival deleted successfully');
        return redirect()->route('arrival-inventory.index');
    }

    public function deleteCheck(string $id)
    {
        $arrival = Arrival::withCount('cost_price')->findOrFail($id);

        if ($arrival->cost_price()->exists()) {
            $costPriceId = $arrival->cost_price->id_cost_price;
            Alert::error('Error', "This Inventory Arrival has associated Cost Price : { $costPriceId } and cannot be deleted.");
        }

        return redirect()->route('arrival-inventory.index');
    }
}