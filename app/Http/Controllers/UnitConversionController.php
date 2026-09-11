<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Unit;
use App\Models\UnitConversion;
use App\Http\Requests\UnitConversionRequest;
use App\Services\UnitConversionService;

class UnitConversionController extends Controller
{
    public function __construct(
        protected UnitConversionService $unitConversionService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = UnitConversion::with('details')->get();
        return view('setup.unit-conversion.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unit   = Unit::pluck('unit_id', 'description');
        $nextId = $this->unitConversionService->generateNextId();

        return view('setup.unit-conversion.create', compact('unit', 'nextId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitConversionRequest $request)
    {
        $validated = $request->validated();

        $duplicates = $this->unitConversionService->findDuplicateUnits($validated['unit_id']);

        if (!empty($duplicates)) {
            return back()
                ->withErrors(['unit_id' => 'There are duplicate unit IDs in the request: ' . implode(', ', $duplicates)])
                ->withInput();
        }

        $this->unitConversionService->store($validated);

        Alert::success('Success', 'Unit Conversion created successfully.');
        return redirect()->route('unit-conversions.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unit           = Unit::pluck('unit_id', 'description');
        $unitConversion = UnitConversion::with('details')->findOrFail($id);

        return view('setup.unit-conversion.update', compact('unitConversion', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitConversionRequest $request, string $id)
    {
        $validated = $request->validated();

        $duplicates = $this->unitConversionService->findDuplicateUnits($validated['unit_id']);

        if (!empty($duplicates)) {
            Alert::error('Error', 'There are duplicate unit IDs in the request: ' . implode(', ', $duplicates));
            return back()->withInput();
        }

        $this->unitConversionService->update($id, $validated);

        Alert::success('Success', 'Unit Conversion updated successfully.');

        return redirect()->route('unit-conversions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->unitConversionService->destroy($id);

        Alert::success('Success', 'Unit Conversion deleted successfully.');

        return redirect()->route('unit-conversions.index');
    }
}
