<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data  = Item::all();
        return view('master.items.index', compact('data'));
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
        $validatedData = $request->validate([
            'item_id' => 'required|unique:item,item_id|max:25',
            'description' => 'required|max:255',
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
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            // 'item_id'   => 'required|unique:item,item_id|max:25',
            'description' => 'required|max:255',
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
        //
        Item::findorFail($id)->delete();
        Alert::success('Success', 'Item has been deleted!');
        return redirect()->route('items.index');
    }
}