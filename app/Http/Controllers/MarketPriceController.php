<?php

namespace App\Http\Controllers;

use App\Models\MarketPrice;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MarketPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MarketPrice::orderBy('effective_date', 'desc')->get();
        return view('master.market_price.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'effective_date' => 'required|date',
        ]);

        // Generate ID Market Price Sequence
        $id = 'MP-' . str_pad(MarketPrice::count() + 1, 3, '0', STR_PAD_LEFT);

        MarketPrice::create([
            'id_market_price'   => $id,
            'effective_date'    => $request->effective_date,
            'keterangan'        => $request->keterangan,
        ]);

        return redirect()->route('market-price.index')->with('success', 'Market Price created successfully');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'effective_date' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $marketPrice = MarketPrice::findOrFail($id);
        $marketPrice->update([
            'effective_date' => $request->effective_date,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('market-price.index')->with('success', 'Market Price updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $marketPrice = MarketPrice::findOrFail($id);
        $marketPrice->delete();

        return redirect()->route('market-price.index')->with('success', 'Market Price deleted successfully');
    }
}