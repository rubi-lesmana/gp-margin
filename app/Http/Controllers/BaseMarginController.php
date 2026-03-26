<?php

namespace App\Http\Controllers;

use App\Models\BaseMargin;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BaseMarginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BaseMargin::all();
        return view('configuration.basemargin.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'margin_percentage' => 'required|numeric|min:0|max:100',
        ]);

        BaseMargin::create([
            // setelah diubah di Model BaseMargin accessor/mutator
            'margin_percentage' => $request->margin_percentage,
        ]);
        Alert::success('Success', 'Base Margin has been added successfully');
        return redirect()->route('base-margin.index');
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
            'margin_percentage' => 'required|numeric|min:0|max:100',
        ]);

        BaseMargin::findOrFail($id)->update([
            // setelah diubah di Model BaseMargin accessor/mutator
            'margin_percentage' => $request->margin_percentage,
        ]);
        Alert::success('Success', 'Base Margin has been updated successfully');
        return redirect()->route('base-margin.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BaseMargin::findOrFail($id)->delete();
        Alert::success('Success', 'Base Margin has been deleted successfully');
        return redirect()->route('base-margin.index');
    }
}