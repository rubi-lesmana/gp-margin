<?php

namespace App\Http\Controllers;

use App\Models\Arrival;
use App\Models\CostPrice;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CostPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CostPrice::with('arrival', 'item', 'selling_prices')
            ->withCount('selling_prices')
            ->orderBy('id_cost_price', 'desc')
            ->get();
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

        Alert::success('Success','Cost price has been created successfully.');
        return redirect()->route('cost-price.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $costPrice = CostPrice::with(['arrival.item', 'selling_prices'])->findOrFail($id);

        // Pengecekan apakah cost price sudah dipakai di selling price, jika sudah maka tidak bisa diedit
        if ($costPrice->selling_prices()->exists()) {
            $sellingPriceIds = $costPrice->selling_prices->pluck('id_selling_price')->implode(', ');
            Alert::warning('Warning',"This cost price has been used in selling prices : {$sellingPriceIds}  and cannot be edited.");
            return redirect()->route('cost-price.index');
        }

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
 
        Alert::success('Success','Cost price has been updated successfully.');
        return redirect()->route('cost-price.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cost_price = CostPrice::findOrFail($id);

        // Pengecekan apakah cost price sudah dipakai di selling price, jika sudah maka tidak bisa dihapus
        if ($cost_price->selling_prices()->exists()) {
            // Tampilkan pesan error jika sudah digunakan di selling price
            Alert::error('Error','This cost price has been used in selling prices and cannot be deleted.');
            return redirect()->route('cost-price.index');
        }
        $cost_price->delete();
        
        Alert::success('Deleted','Cost price has been deleted successfully.');
        return redirect()->route('cost-price.index');
   }
}