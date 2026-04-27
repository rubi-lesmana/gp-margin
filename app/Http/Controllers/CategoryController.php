<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService)
    {
        // 
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::orderBy('min_quantity')->get();
        return view('configuration.category.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'status'       => 'required|string|max:15',
            'min_quantity' => 'required|integer|min:0',
            'max_quantity' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    if (!is_null($value) && $value <= $request->input('min_quantity')) {
                        $fail('Max quantity harus lebih besar dari min quantity.');
                    }
                },
            ],
            'calculation'  => 'required|numeric|min:0',
        ]);

        $this->categoryService->store($validated);

        Alert::success('Success', 'Category has been added successfully');

        return redirect()->route('category.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $status)
    {
        $category = Category::findOrFail($status);

        $validated = $request->validate([
            'status'       => 'required|string|max:15',
            'min_quantity' => 'required|integer|min:0',
            'max_quantity' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    if (!is_null($value) && $value <= $request->input('min_quantity')) {
                        $fail('Max quantity harus lebih besar dari min quantity.');
                    }
                },
            ],
            'calculation'  => 'required|numeric|min:0',
        ]);

        $this->categoryService->update($category, $validated);

        Alert::success('Success', 'Category has been updated successfully');
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $status)
    {
        $category = Category::findOrFail($status);

        $this->categoryService->destroy($category);
        Alert::success('Success', 'Category has been deleted successfully');
        return redirect()->route('category.index');
    }
}