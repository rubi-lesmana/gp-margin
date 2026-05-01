<?php

namespace App\Services;

use App\Models\BaseMargin;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Collection;

class SellingPriceService
{
     /**
     * Ambil semua status dari tabel category,
     * hitung GP Margin per status berdasarkan calculation masing-masing.
     *
     * Rumus: margin_percentage * calculation
     */
    public function calculateGpMarginAllStatuses(): Collection
    {
          $base_margin        = BaseMargin::first();
          $marginPercentage   = $base_margin->margin_percentage;

          $items   = Item::all();
          $categories = Category::all();

          // Cross: setiap produk tampil sebanyak jumlah status
          $rows = collect();

          foreach ($items as $item) {
               foreach ($categories as $category) {
                    $gpMargin = ($marginPercentage * $category->calculation) * 100; // Kalikan dengan 100 untuk mendapatkan nilai dalam persen

                    $rows->push((object) [
                         'item_id'     => $item->item_id,
                         'description' => $item->description,
                         'status'      => $category->status,
                         'calculation' => (float) $category->calculation,
                         'gp_margin'   => round($gpMargin, 2),
                    ]);
               }
          }

          return $rows;
    }
}


?>