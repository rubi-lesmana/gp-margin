<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Supplier::all();
        return view('master.supplier.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_supplier'   => 'required|unique:suppliers,id_supplier',
            'supplier_name' => 'required|max:100',
            'address'       => 'required|max:255',
            'country'       => 'required|max:50'
        ]);

        Supplier::create([
            'id_supplier'   => $request->id_supplier,
            'supplier_name' => $request->supplier_name,
            'address'       => $request->address,
            'country'       => ucfirst(strtolower($request->country)),
        ]);

        Alert::success('Success', 'Supplier created successfully.');
        return redirect()->route('suppliers.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_name' => 'required|max:100',
            'address'       => 'required|max:255',
            'country'       => 'required|max:50'
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'supplier_name' => $request->supplier_name,
            'address'       => $request->address,
            'country'       => ucfirst(strtolower($request->country)),
        ]);

        Alert::success('Success', 'Supplier updated successfully.');
        return redirect()->route('suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        Alert::success('Success', 'Supplier deleted successfully.');
        return redirect()->route('suppliers.index');
    }
}
