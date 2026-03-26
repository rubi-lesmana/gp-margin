<?php

namespace App\Http\Controllers;

use App\Models\Arrival;
use App\Models\Item;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ArrivalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Arrival::with('item')->get();
        return view('master.arrival.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $item       = Item::pluck('description', 'item_id')->toArray();
        // Get ItemID yang sudah ada di tabel arrival
        $usedItem   = Arrival::pluck('item_id')->unique()->toArray();
        // Filter semua itemID yang belum ada di tabel arrival
        $availableItem = array_diff_key($item, array_flip($usedItem));
        ksort($availableItem);
        return view('master.arrival.create', compact('item', 'usedItem', 'availableItem'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id'       => 'required|string|exists:item,item_id',
            'status'        => 'required|string',
            'quantity'      => 'required|numeric',
            'date'          => 'required|date',
            'keterangan'    => 'nullable|string',
        ]);

        Arrival::create([
            'item_id'       => $request->item_id,
            'status'        => $request->status,
            'quantity'      => $request->quantity,
            'date'          => $request->date,
            'keterangan'    => $request->keterangan,
        ]);

        Alert::success('Success', 'Inventory Arrival created successfully');
        return redirect()->route('arrival-inventory.index');
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
            'status' => 'required|string',
            'quantity' => 'required|numeric',
            'date' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $arrival = Arrival::findOrFail($id);
        $arrival->update([
            'status' => $request->status,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'keterangan' => $request->keterangan,
        ]);

        Alert::success('Success', 'Inventory Arrival updated successfully');
        return redirect()->route('arrival-inventory.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $arrival = Arrival::findOrFail($id);
        $arrival->delete();

        Alert::success('Success', 'Inventory Arrival deleted successfully');
        return redirect()->route('arrival-inventory.index');
    }
}
