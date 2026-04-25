<?php

namespace App\Http\Controllers;

use App\Models\TermOfPayment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TermOfPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TermOfPayment::all();
        return view('configuration.top.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'days' => 'required|integer',
            'description' => 'required|string|max:255',
        ]);

        TermOfPayment::create([
            'days' => $request->days,
            'description' => $request->description,
        ]);

        Alert::success('Success', 'Term of Payment created successfully.');
        return redirect()->route('term-of-payment.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'days' => 'required|integer',
            'description' => 'required|string|max:255',
        ]);

        $top = TermOfPayment::findOrFail($id);
        $top->update([
            'days' => $request->days,
            'description' => $request->description,
        ]);

        Alert::success('Success', 'Term of Payment updated successfully.');
        return redirect()->route('term-of-payment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $top = TermOfPayment::findOrFail($id);
        $top->delete();

        Alert::success('Success', 'Term of Payment deleted successfully.');
        return redirect()->route('term-of-payment.index');
    }
}