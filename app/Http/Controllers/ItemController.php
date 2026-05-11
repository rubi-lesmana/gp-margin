<?php

namespace App\Http\Controllers;

use App\Models\BaseMargin;
use App\Models\Item;
use App\Models\Pareto;
use App\Models\Unit;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data  = Item::with('base_margin')->get();
        return view('master.items.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Item::with('base_margin')->get();
        // $base_margins = BaseMargin::pluck('margin_percentage', 'id');
        $base_margins = BaseMargin::all()->mapWithKeys(function ($margin) {
            return [$margin->id => $margin->margin_percentage_format]; // hasil accessor, misal "10%"
        });
        // $units = Unit::pluck('unit_name', 'unit_id');
        $units = Unit::all()->mapWithKeys(function ($unit) {
            return [$unit->unit_id => $unit->description];
        });
        // $paretos = Pareto::pluck('pareto_name', 'id');
        $paretos = Pareto::all()->mapWithKeys(function ($pareto) {
            return [$pareto->id => $pareto->description];
        });
        return view('master.items.create', compact('data', 'base_margins', 'units', 'paretos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'item_id'           => 'required|unique:item,item_id|max:25',
            'description'       => 'required|max:255',
            'base_margin_id'    => 'required|exists:base_margin,id',
            'unit_id'           => 'required|exists:units,unit_id',
            'pareto_id'         => 'required|exists:paretos,id',
        ]);

        Item::create($validatedData);
        Alert::success('Success', 'New item has been added!');
        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::findOrFail($id);  
        // $base_margins = BaseMargin::pluck('margin_percentage', 'id');
        $base_margins = BaseMargin::all()->mapWithKeys(function ($margin) {
            return [$margin->id => $margin->margin_percentage_format]; // hasil accessor, misal "10%"
        });
        // $units = Unit::pluck('unit_name', 'unit_id');
        $units = Unit::all()->mapWithKeys(function ($unit) {
            return [$unit->unit_id => $unit->description];
        });
        // $paretos = Pareto::pluck('pareto_name', 'id');
        $paretos = Pareto::all()->mapWithKeys(function ($pareto) {
            return [$pareto->id => $pareto->description];
        });
        return view('master.items.update', compact('item', 'base_margins', 'units', 'paretos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            // 'item_id'   => 'required|unique:item,item_id|max:25',
            'description'       => 'required|max:255',
            'base_margin_id'    => 'required|exists:base_margin,id',
            'unit_id'           => 'required|exists:units,unit_id',
            'pareto_id'         => 'required|exists:paretos,id',
        ]);
        
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