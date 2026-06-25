<?php

namespace App\Http\Controllers;

use App\Models\SellingPriceDetail;
use Illuminate\Support\Facades\DB;

class PriceListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('view_price_list')
            ->orderBy('id_selling_price', 'desc')
            ->get();
        
        return view('price-list.index', compact('data'));
    }

    public function show(string $id_selling_price)
    {
        $data = DB::table('view_price_list')
            ->where('id_selling_price', $id_selling_price)
            ->get();
            
        $detailsCategory = SellingPriceDetail::where('selling_price_id', $id_selling_price)
            ->orderBy('adj_gp_margin_price')
            ->orderBy('top_days_snapshot')
            ->get()
            ->groupBy('category_status');

        return view('price-list.show', compact('data', 'detailsCategory'));
    }
}