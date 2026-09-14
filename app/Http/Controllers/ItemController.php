<?php

namespace App\Http\Controllers;

use App\Models\BaseMargin;
use App\Models\Item;
use App\Models\Pareto;
use App\Models\Unit;
use App\Models\UnitConversion;
use App\Http\Requests\ItemRequest;
use RealRashid\SweetAlert\Facades\Alert;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data  = Item::with('base_margin', 'unit', 'unit_conversion', 'arrivals')
            ->withCount('arrivals')
            ->get();
        return view('master.items.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data               = Item::with('base_margin')->get();
        $base_margins       = BaseMargin::all()->mapWithKeys(function ($margin) {
            return [$margin->id => $margin->margin_percentage_format]; // hasil accessor, misal "10%"
        });
        $units              = Unit::pluck('description', 'unit_id');
        $unitConversions    = UnitConversion::pluck('description', 'id_unit_conversion');
        $paretos            = Pareto::pluck('description', 'id');
        return view('master.items.create', compact('data', 'base_margins', 'units', 'unitConversions', 'paretos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        $validatedData = $request->validated();

        Item::create($validatedData);
        Alert::success('Success', 'New item has been added!');
        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $item->load('base_margin', 'pareto', 'unit', 'unit_conversion');
        
        return view('master.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item               = Item::findOrFail($id);
        $base_margins       = BaseMargin::all()->mapWithKeys(function ($margin) {
            return [$margin->id => $margin->margin_percentage_format]; // hasil accessor, misal "10%"
        });
        $units              = Unit::pluck('description', 'unit_id');
        $paretos            = Pareto::pluck('description', 'id');
        $unitConversions    = UnitConversion::pluck('description', 'id_unit_conversion');
        
        return view('master.items.update', compact('item', 'base_margins', 'units', 'unitConversions', 'paretos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, string $id)
    {
        $validatedData = $request->validated();

        Item::findOrFail($id)->update($validatedData);
        Alert::success('Success', 'Item has been updated!');
        return redirect()->route('items.index');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Item::findorFail($id)->delete();
        Alert::success('Success', 'Item has been deleted!');
        return redirect()->route('items.index');
    }
}