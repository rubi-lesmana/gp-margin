<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::all();
        return view('configuration.category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status'        => 'required|string|max:25',
            'min'           => 'required|integer|min:0',
            'max'           => 'required|integer|min:0',
            'calculation'   => 'required|numeric|min:0',
        ]);

        Category::create([
            'status'        => $request->status,
            'min'           => $request->min,
            'max'           => $request->max,
            'calculation'   => $request->calculation,
        ]);

        Alert::success('Success', 'Category has been added successfully');

        return redirect()->route('category.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status'        => 'required|string|max:25',
            'min'           => 'required|integer|min:0',
            'max'           => 'required|integer|min:0',
            'calculation'   => 'required|numeric|min:0',
        ]);

        Category::findOrFail($id)->update([
            'status'        => $request->status,
            'min'           => $request->min,
            'max'           => $request->max,
            'calculation'   => $request->calculation,
        ]);

        Alert::success('Success', 'Category has been updated successfully');

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();
        Alert::success('Success', 'Category has been deleted successfully');
        return redirect()->route('category.index');
    }
}