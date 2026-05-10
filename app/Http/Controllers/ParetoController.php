<?php

namespace App\Http\Controllers;

use App\Models\Pareto;
use Illuminate\Http\Request;

class ParetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pareto::all();
        return view('setup.pareto.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
        ]);

        Pareto::create($request->all());

        return redirect()->route('pareto.index')
            ->with('success', 'Pareto created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'description' => 'required',
        ]);

        $pareto = Pareto::find($id);
        $pareto->update($request->all());

        return redirect()->route('pareto.index')
            ->with('success', 'Pareto updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pareto = Pareto::find($id);
        $pareto->delete();

        return redirect()->route('pareto.index')
            ->with('success', 'Pareto deleted successfully.');
    }
}