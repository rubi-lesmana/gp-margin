<?php

namespace App\Http\Controllers;

use App\Models\DoiPercentage;
use App\Services\DoiPercentagesService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DoiPercentageController extends Controller
{
    public function __construct(protected DoiPercentagesService $service)
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DoiPercentage::all();

        // Kondisi  jika Max Days Null, maka tampilkan "Above X Days"
        foreach ($data as $doi) {
            if (is_null($doi->max_days)) {
                $doi->label = "Above {$doi->min_days} Days";
            } else {
                $doi->label = "Between {$doi->min_days} and {$doi->max_days} Days";
            }
        }
        return view('configuration.doi.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'min_days'      => 'required|integer|min:0',
            'max_days'   => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    if (!is_null($value) && $value <= $request->input('min_days')) {
                        $fail('Max days harus lebih besar dari min days.');
                    }
                },
            ],
            'percentage'    => 'required|numeric|min:0',
            'label'         => 'nullable|string|max:255',
        ]);

        $this->service->store($validated);

        Alert::success('Success', 'DOI Percentage created successfully.');
        return redirect()->route('doi-percentage.index')->with('success', 'DOI Percentage created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $doiPercentage = DoiPercentage::findOrFail($id);

        $validated = $request->validate([
            'min_days'   => 'required|integer|min:0',
            'max_days'   => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    if (!is_null($value) && $value <= $request->input('min_days')) {
                        $fail('Max days harus lebih besar dari min days.');
                    }
                },
            ],
            'percentage' => 'required|numeric|min:0',
            'label'      => 'nullable|string|max:255',
        ]);

        $this->service->update($doiPercentage, $validated);

        Alert::success('Success', 'DOI Percentage updated successfully.');
        return redirect()->route('doi-percentage.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doiPercentage = DoiPercentage::findOrFail($id);

        $this->service->destroy($doiPercentage);

        Alert::success('Success', 'DOI Percentage deleted successfully.');
        return redirect()->route('doi-percentage.index');
    }
}