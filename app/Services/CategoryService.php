<?php

namespace App\Services;

use App\Models\BaseMargin;
use App\Models\Category;

class CategoryService
{
     public function resolveStatus(int $quantity): ?array
     {
          $category = Category::whereBetween('min', [0, $quantity])
               ->where('max', '>=', $quantity)
               ->first();
          
          // Mengambil nilai calculation pada tabel Category
          $calculation = $category?->calculation;

          // Menghitung GP Margin menggunakan nilai calculation
          $gpmargin = $this->gpMarginService($calculation);
               
          return [
               'status'       => $category?->status,
               'calculation'  => $calculation,
               'gpmargin'     => $gpmargin
          ];
     }

     private function gpMarginService(float $calculation): array
     {
          $base_margin        = BaseMargin::first();
          $marginPercentage   = $base_margin->margin_percentage;

          // Final Margin
          $finalMargin = $marginPercentage  * $calculation;
          
          return [
               'margin_percentage' => $marginPercentage,
               'final_margin'      => $finalMargin
          ];
     }
}

?>