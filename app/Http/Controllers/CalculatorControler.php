<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Models\Item;
use Illuminate\Http\Request;

class CalculatorControler extends Controller
{

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::pluck('description', 'item_id');
        return view('transaction.calculator.index', compact('items'));
    }

    public function calculate(Request $request)
    {
        $items = Item::pluck('description', 'item_id');

        $itemId     = $request->input('item_id');
        $quantity   = (int) $request->input('quantity');
        $costPrice  = $request->input('cost_price');
        $top        = $request->input('top');

        // Category Service
        $result         = $this->categoryService->resolveStatus($quantity);
        $status         = $result['status'];
        $calculation    = $result['calculation'] * 100;

        $gpmargin       = $result['gpmargin'];
        // Mengalikan masing-masing isi array gpmargin dengan 100
        $gpmargin['margin_percentage'] *= 100;
        $gpmargin['final_margin']      *= 100;

        
        return view('transaction.calculator.index', compact(
            'items',
            'status',
            'itemId',
            'quantity',
            'costPrice',
            'top',
            'calculation',
            'gpmargin'
        ));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}