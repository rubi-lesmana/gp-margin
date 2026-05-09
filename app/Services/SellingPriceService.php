<?php

namespace App\Services;

use App\Models\Arrival;
use App\Models\DoiPercentage;
use App\Models\SellingPrice;
use Illuminate\Support\Collection;

class SellingPriceService
{
     /**
     * Ambil semua data dengan target GP after DOI
     */
     public function getAll(): Collection
     {
          $sellingPrices = SellingPrice::all();
          return $this->attachDoiCalculation($sellingPrices);
     }

     /**
     * Filter per item_id
     */
     public function getByItem(string $itemId): Collection
     {
          $sellingPrices = SellingPrice::where('item_id', $itemId)->get();
          return $this->attachDoiCalculation($sellingPrices);
     }

     /**
     * Core: hitung DOI per item lalu kurangi dari target_gp
     */
     private function attachDoiCalculation(Collection $sellingPrices): Collection
     {
          // Load semua doi_percentages sekali (hindari N+1)
          $doiPercentages = DoiPercentage::orderBy('min_days')->get();

          // Load 2 kedatangan terakhir per item sekaligus (hindari N+1)
          $doiDaysMap = $this->getDoiDaysPerItem(
               $sellingPrices->pluck('item_id')->unique()->values()->all()
          );

          return $sellingPrices->map(function ($row) use ($doiDaysMap, $doiPercentages) {
               $itemId  = $row->item_id;
               $doiDays = $doiDaysMap[$itemId] ?? null;

               // Match range DOI ke doi_percentages
               $doiPct  = $this->matchDoiPercentage($doiDays, $doiPercentages);

               // Hitung target_gp_after_doi
               $targetGpAfterDoi = $doiDays !== null
                    ? round($row->target_gp - ($doiPct->percentage / 100), 4)
                    : $row->target_gp; // belum ada 2 data kedatangan → tidak dikurangi

               $row->doi_days             = $doiDays;
               $row->doi_percentage       = $doiPct?->percentage ?? 0;
               $row->doi_label            = $doiPct?->label ?? '-';
               $row->target_gp_after_doi  = $targetGpAfterDoi;

               return $row;
          });
     }

     /**
     * Hitung DOI days per item dari 2 kedatangan terakhir
     * Return: ['ITEM001' => 45, 'ITEM002' => 90, ...]
     */
     private function getDoiDaysPerItem(array $itemIds): array
     {
          $result = [];

          // Ambil 2 kedatangan terakhir per item dalam 1 query
          $arrivals = Arrival::whereIn('item_id', $itemIds)
               ->orderBy('item_id')
               ->orderByDesc('date')
               ->get()
               ->groupBy('item_id');

          foreach ($arrivals as $itemId => $rows) {
               if ($rows->count() >= 2) {
                    $last = $rows->get(0)->date;
                    $prev = $rows->get(1)->date;
                    $result[$itemId] = $last->diffInDays($prev);
               }
          }

          return $result;
     }

     /**
     * Cocokkan doi_days ke range di doi_percentages
     */
     private function matchDoiPercentage(?int $doiDays, Collection $doiPercentages): ?DoiPercentage
     {
          if ($doiDays === null) return null;

          return $doiPercentages->first(function ($dp) use ($doiDays) {
               $inMin = $doiDays >= $dp->min_days;
               $inMax = is_null($dp->max_days) || $doiDays <= $dp->max_days;
               return $inMin && $inMax;
          });
     }
}

?>