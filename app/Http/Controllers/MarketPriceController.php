<?php

namespace App\Http\Controllers;

use App\Models\Item;
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
        $data = MarketPrice::with('item')->get();
        return view('master.market_price.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $item = Item::pluck('description', 'item_id')->toArray();
        // Get ItemID yang sudah ada di tabel market_price
        $usedItem = MarketPrice::pluck('item_id')->unique()->toArray();
        // Filter semua itemID yang belum ada di tabel market_price
        $availableItem = array_diff_key($item, array_flip($usedItem));
        ksort($availableItem);
        return view('master.market_price.create', compact('item', 'usedItem', 'availableItem'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id'       => 'required|string|exists:item,item_id',
            'price'         => 'required|numeric',
            'keterangan'    => 'nullable|string',
        ]);

        MarketPrice::create([
            'item_id'       => $request->item_id,
            'price'         => $request->price,
            'keterangan'    => $request->keterangan,
        ]);

        Alert::success('Success', 'Market Price created successfully');
        return redirect()->route('market-price.index');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'price' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $marketPrice = MarketPrice::findOrFail($id);
        $marketPrice->update([
            'price' => $request->price,
            'keterangan' => $request->keterangan,
        ]);

        Alert::success('Success', 'Market Price updated successfully');
        return redirect()->route('market-price.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $marketPrice = MarketPrice::findOrFail($id);
        $marketPrice->delete();

        Alert::success('Success', 'Market Price deleted successfully');
        return redirect()->route('market-price.index');
    }
}
