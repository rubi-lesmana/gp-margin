<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemHistory;
use Illuminate\Http\Request;

class ItemHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ItemHistory::with('item')->get();
        $items = Item::pluck('description', 'item_id');
        return view('master.item-history.index', compact('data', 'items'));
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
            'item_id'       => 'required|string|exists:item,item_id',
            'date_report'   => 'required|date',
            'ending_stock'  => 'required|numeric',
        ]);

        ItemHistory::create([
            'item_id'       => $request->item_id,
            'date_report'   => $request->date_report,
            'ending_stock'  => $request->ending_stock,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('item-history.index')->with('success', 'Item history has been added successfully');
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
        $request->validate([
            'item_id'       => 'required|string|exists:item,item_id',
            'date_report'   => 'required|date',
            'ending_stock'  => 'required|numeric',
        ]);

        $itemHistory = ItemHistory::findOrFail($id);
        $itemHistory->update([
            'item_id'       => $request->item_id,
            'date_report'   => $request->date_report,
            'ending_stock'  => $request->ending_stock,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('item-history.index')->with('success', 'Item history has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $itemHistory = ItemHistory::findOrFail($id);
        $itemHistory->delete();

        return redirect()->route('item-history.index')->with('success', 'Item history has been deleted successfully');
    }
}