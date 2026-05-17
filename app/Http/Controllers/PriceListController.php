<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = DB::table('item as i')
            ->leftJoin('selling_prices as sp', function ($join) {
                $join->on('sp.item_id', '=', 'i.item_id')
                    ->where('sp.status', '=', 'approved');
            })
            ->leftJoin('selling_price_details as spd', 'spd.selling_price_id', '=', 'sp.id_selling_price')
            ->leftJoin('cost_prices as cp', 'cp.id_cost_price', '=', 'sp.cost_price_id')
            ->leftJoin('users as u', 'u.id', '=', 'sp.approved_by')
            ->select([
                'i.item_id',
                'i.description',
                'sp.id_selling_price',
                'sp.cost_price_snapshot',
                'sp.market_price_snapshot',
                'sp.approved_at',
                'sp.status',
                'u.name as approved_by_name',
                'cp.date as cost_price_date',
                DB::raw('MIN(spd.suggested_selling_price) as ssp_min'),
                DB::raw('MAX(spd.suggested_selling_price) as ssp_max'),
            ])
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('i.item_id', 'like', "%{$request->search}%")
                    ->orWhere('i.description', 'like', "%{$request->search}%");
                });
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                if ($request->status === 'approved') {
                    $q->whereNotNull('sp.id_selling_price');
                } elseif ($request->status === 'no_ssp') {
                    $q->whereNull('sp.id_selling_price');
                }
            })
            ->groupBy(
                'i.item_id',
                'i.description',
                'sp.id_selling_price',
                'sp.cost_price_snapshot',
                'sp.market_price_snapshot',
                'sp.approved_at',
                'sp.status',
                'u.name',
                'cp.date',
            )
            ->orderByRaw('sp.id_selling_price IS NULL ASC')
            ->orderBy('i.item_id')
            ->paginate(5)
            ->withQueryString();

        return view('price-list.index', compact('items'));
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