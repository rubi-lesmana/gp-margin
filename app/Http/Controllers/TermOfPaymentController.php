<?php

namespace App\Http\Controllers;

use App\Models\TermOfPayment;
use App\Models\TgpMargin;
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

    /*`*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = TermOfPayment::with('tgp_margins')->get();
        $tgp_margins = TgpMargin::all()->mapWithKeys(function ($tgp) {
            return [$tgp->id => $tgp->margin_percentage_format]; // hasil accessor, misal "10%"
        });
        return view('configuration.top.create', compact('data', 'tgp_margins'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'days'          => 'required|integer',
            'description'   => 'required|string|max:255',
            'percent_id'    => 'nullable|exists:tgp_margins,id',
        ]);

        TermOfPayment::create([
            'days'          => $request->days,
            'description'   => $request->description,
            'percent_id'    => $request->percent_id,
        ]);

        Alert::success('Success', 'Term of Payment created successfully.');
        return redirect()->route('term-of-payment.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TermOfPayment $termOfPayment)
    {
        //
    }   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $top = TermOfPayment::findOrFail($id);
        $tgp_margins = TgpMargin::all()->mapWithKeys(function ($tgp) {
            return [$tgp->id => $tgp->margin_percentage_format]; // hasil accessor, misal "10%"
        });
        return view('configuration.top.update', compact('top', 'tgp_margins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'days'          => 'required|integer',
            'description'   => 'required|string|max:255',
            'percent_id'    => 'nullable|exists:tgp_margins,id',
        ]);

        $top = TermOfPayment::findOrFail($id);
        $top->update([
            'days'          => $request->days,
            'description'   => $request->description,
            'percent_id'    => $request->percent_id,
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