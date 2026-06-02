<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class StockController extends Controller
{
    private ApiService $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function getStock(Request $request)
    {
        // Gunakan query param jika ada, fallback ke nilai default
        $date       = $request->query('date', now()->format('Y-m-d'));
        $locationId = $request->query('locationId', '03GDF');
        $itemId     = $request->query('itemId', '80.80.70.20.001');

        $result = $this->apiService->getStockOnHand($date, $locationId, $itemId);

        return view('stock.index', [
            'result'     => $result,
            'date'       => $date,
            'locationId' => $locationId,
            'itemId'     => $itemId,
        ]);
    }
}