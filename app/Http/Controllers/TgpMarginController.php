<?php

namespace App\Http\Controllers;

use App\Models\TgpMargin;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TgpMarginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_tgp = TgpMargin::all();
        return view('configuration.basemargin.targetgp.index', compact('data_tgp'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'margin_percentage' => 'required|numeric|min:0|max:100',
        ]);

        TgpMargin::create([
            // setelah diubah di Model TgpMargin accessor/mutator
            'margin_percentage' => $request->margin_percentage,
        ]);
        Alert::success('Success', 'Target GP Margin has been added successfully');
        return redirect()->route('base-margin.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'margin_percentage' => 'required|numeric|min:0|max:100',
        ]);

        TgpMargin::findOrFail($id)->update([
            // setelah diubah di Model TgpMargin accessor/mutator
            'margin_percentage' => $request->margin_percentage,
        ]);
        Alert::success('Success', 'Target GP Margin has been updated successfully');
        return redirect()->route('base-margin.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TgpMargin::findOrFail($id)->delete();
        Alert::success('Success', 'Target GP Margin has been deleted successfully');
        return redirect()->route('base-margin.index');
    }
}