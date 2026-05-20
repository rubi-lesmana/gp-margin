<?php

namespace App\Http\Controllers;

use App\Models\Arrival;
use App\Models\CostPrice;
use Illuminate\Http\Request;

class CostPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CostPrice::with('arrival', 'item')->orderBy('id_cost_price', 'desc')->get();
        return view('transaction.cost-price.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $arrivals = Arrival::with('item')
                    ->whereDoesntHave('cost_price') // exclude arrival yang sudah punya cost price
                    ->get();
        return view('transaction.cost-price.create', compact('arrivals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Bersihkan format price jika user/input mengirim nilai seperti 39,000.00
        $request->merge([
            'cost_price' => $request->filled('cost_price')
                ? str_replace(',', '', $request->cost_price)
                : null,
        ]);

        // dd($request->all());
        $request->validate([
            'arrival_id'    => 'required','exists:inventory_arrivals,id',
            'date'          => 'required','date',
            'item_id'       => 'required','exists:item,id',
            'cost_price'    => 'required','numeric','min:0',
        ]);

        // Gunakan max ID existing agar tidak bentrok meski ada data yang dihapus
        $latest     = CostPrice::max('id_cost_price');
        $nextNumber = $latest ? (int) substr($latest, 3) + 1 : 1;
        $id         = 'CP-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        CostPrice::create([
            'id_cost_price' => $id,
            'arrival_id'    => $request->arrival_id,
            'date'          => $request->date,
            'item_id'       => $request->item_id,
            'cost_price'    => $request->cost_price,
        ]);

        return redirect()
            ->route('cost-price.index')
            ->with('success', 'Cost Price created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $costPrice = CostPrice::with(['arrival.item',])->findOrFail($id);

        $arrivals = Arrival::with('item')
                ->whereDoesntHave('cost_price')
                ->orWhere('id', $costPrice->arrival_id) // tetap tampilkan arrival yang sedang diedit
                ->get();
        
        return view('transaction.cost-price.update', compact('costPrice', 'arrivals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'arrival_id'       => ['required', 'exists:arrival,id'],
            'cost_price'       => ['required', 'numeric', 'min:0'],
            'date'             => ['required', 'date'],
            'item_id'          => ['required', 'exists:item,item_id'],
            'manual_reference' => ['nullable', 'string', 'max:50'],
        ]);
 
        $costPrice = CostPrice::findOrFail($id);
 
        $costPrice->update([
            'arrival_id'       => $validated['arrival_id'],
            'cost_price'       => $validated['cost_price'],
            'date'             => $validated['date'],
            'item_id'          => $validated['item_id'],
            'manual_reference' => $validated['manual_reference'] ?? null,
        ]);
 
        return redirect()
            ->route('cost-price.index')
            ->with('success', 'Cost Price berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cost_price = CostPrice::findOrFail($id);
        $cost_price->delete();

        return redirect()->route('cost-price.index')
                     ->with('success', 'Cost Price deleted successfully.');
   }
}