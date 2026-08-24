<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArrivalStatus;
use App\Models\Currency;
use RealRashid\SweetAlert\Facades\Alert;

class ArrivalStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ArrivalStatus::all();
        $currencies = Currency::pluck('description', 'id_currency');
        return view('setup.arrival-status.index', compact('data', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->default_currency_id === '') {
            $request->merge(['default_currency_id' => null]);
        }

        try {
            $request->validate([
                'code'                  => 'required|string|max:10|unique:arrival_statuses,code',
                'description'           => 'required|string|max:255',
                'default_currency_id'   => 'nullable|exists:currencies,id_currency',
            ]);
            $arrivalStatus = ArrivalStatus::create($request->all());
            Alert::success('Success', 'Arrival Status created successfully.');
            return redirect()->route('arrival-statuses.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create Arrival Status: ' . $e->getMessage());
            return redirect()->route('arrival-statuses.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            if ($request->default_currency_id === '') {
                $request->merge(['default_currency_id' => null]);
            }
            
            $request->validate([
                'code'                  => 'required|string|max:10|unique:arrival_statuses,code,' . $id,
                'description'           => 'required|string|max:255',
                'default_currency_id'   => 'nullable|exists:currencies,id_currency',
            ]);

            $arrivalStatus = ArrivalStatus::findOrFail($id);
            $arrivalStatus->update($request->all());

            Alert::success('Success', 'Arrival Status updated successfully.');
            return redirect()->route('arrival-statuses.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update Arrival Status: ' . $e->getMessage());
            return redirect()->route('arrival-statuses.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $arrivalStatus = ArrivalStatus::findOrFail($id);
        $arrivalStatus->delete();
        Alert::success('Success', 'Arrival Status deleted successfully.');
        return redirect()->route('arrival-statuses.index');
    }
}
