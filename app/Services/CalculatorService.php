<?php

namespace App\Services;

use App\Models\BaseMargin;
use App\Models\Category;
use App\Models\TgpMargin;

class CalculatorService
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

     public function resolveTgpMargin(float $top, float $finalMargin): array
     {
          $tgpMargin = TgpMargin::first();

          // Fallback ke 0 jika data tidak ditemukan
          $tgpMarginValue = $tgpMargin?->margin_percentage * 100 ?? 0;

          // Formula untuk menghitung Target GP Margin
          $targetGPMargin = ($top / 365 * $tgpMarginValue) + $finalMargin;
          
          return [
               'tgp_value' => $tgpMarginValue,
               'tgp_margin' => $targetGPMargin
          ];
     }
}

?>