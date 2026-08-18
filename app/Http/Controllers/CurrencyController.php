<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use RealRashid\SweetAlert\Facades\Alert;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Currency::all();
        return view('setup.currency.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_currency' => 'required|unique:currencies,id_currency',
            'description' => 'required',
        ]);

        Currency::create($request->all());

        Alert::success('Success', 'Currency created successfully.');
        return redirect()->route('currencies.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'description' => 'required',
        ]);

        $currency = Currency::findOrFail($id);
        $currency->update($request->all());

        Alert::success('Success', 'Currency updated successfully.');
        return redirect()->route('currencies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();

        Alert::success('Success', 'Currency deleted successfully.');
        return redirect()->route('currencies.index');
    }
}
