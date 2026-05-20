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
        // Get data Item with unit 
        $items      = Item::with('unit')->get();

        // Pluck data item_id dan description untuk dropdown select
        $item       = $items->pluck('description', 'item_id')->toArray();

        // map Item dengan unit untuk menampilkan satuan di dropdown select
        $itemUnits = $items->mapWithKeys(function ($item) {
            return [$item->item_id => $item->unit->unit_id ?? ''];
        })->toArray();
        
        return view('master.arrival.create', compact('item', 'itemUnits'));
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
            'unit_id'       => 'required|string|exists:units,unit_id',
            'unit_price'    => 'required|numeric',
            'net_amount'    => 'required|numeric',
        ]);

        // 1. Ambil record terakhir berdasarkan ID terbesar
        $lastArrival = Arrival::orderBy('id', 'desc')->first();

        if ($lastArrival) {
            // Mengambil angka dari ID terakhir (misal 'ARR-0004' diambil '0004' lalu diubah ke integer jadi 4)
            $lastNumber = (int) substr($lastArrival->id, 4);
            $nextNumber = $lastNumber + 1;
        } else {
            // Jika belum ada data sama sekali di database
            $nextNumber = 1;
        }

        // 2. Generate ID baru dengan format ARR-XXXX
        $id = 'ARR-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        Arrival::create([
            'id'            => $id,
            'item_id'       => $request->item_id,
            'status'        => $request->status,
            'quantity'      => $request->quantity,
            'date'          => $request->date,
            'keterangan'    => $request->keterangan,
            'unit_id'       => $request->unit_id,
            'unit_price'    => $request->unit_price,
            'net_amount'    => $request->net_amount,
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
        $arrival    = Arrival::findOrFail($id);

        $items      = Item::with('unit')->get();
        $item       = $items->pluck('description', 'item_id')->toArray();
        $itemUnits  = $items->mapWithKeys(function ($item) {
            return [$item->item_id => $item->unit->unit_id ?? ''];
        })->toArray();

        return view('master.arrival.update', compact('arrival', 'item', 'itemUnits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status'        => 'required|string',
            'quantity'      => 'required|numeric',
            'date'          => 'required|date',
            'keterangan'    => 'nullable|string',
            'unit_id'       => 'required|string|exists:units,unit_id',
            'unit_price'    => 'required|numeric',
            'net_amount'    => 'required|numeric',
        ]);

        $arrival = Arrival::findOrFail($id);
        $arrival->update([
            'status'        => $request->status,
            'quantity'      => $request->quantity,
            'date'          => $request->date,
            'keterangan'    => $request->keterangan,
            'unit_id'       => $request->unit_id,
            'unit_price'    => $request->unit_price,
            'net_amount'    => $request->net_amount,
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