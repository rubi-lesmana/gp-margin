<?php

namespace App\Http\Controllers;

use App\Models\MarketPriceDetail;
use Illuminate\Http\Request;

class MarketPriceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        foreach ($request->details as $detail) {
            MarketPriceDetail::create([
                'market_price_id' => $request->id_market_price,
                'item_id'         => $detail['item_id'],
                'price'           => $detail['price'],
            ]);
        }

        return redirect()->back()->with('success', 'Market price detail saved.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        foreach ($request->details as $detail) {
            MarketPriceDetail::where('id', $detail['id_detail'])
                ->update([
                    'price' => $detail['price'],
                ]);
        }

        return redirect()->back()->with('success', 'Market price detail updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}