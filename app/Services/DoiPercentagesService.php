<?php

namespace App\Services;

use App\Models\DoiPercentage;
use Illuminate\Validation\ValidationException;

class DoiPercentagesService
{
    /**
     * Validasi overlap range days dengan data existing.
     */
     public function checkOverlap(int $minDays, ?int $maxDays, ?int $excludeId = null): void
     {
          $overlap = DoiPercentage::where(function ($query) use ($minDays, $maxDays) {
                    if (is_null($maxDays)) {
                         $query->where('min_days', '>=', $minDays)
                         ->orWhere(function ($q) use ($minDays) {
                              $q->where('min_days', '<=', $minDays)
                                   ->where(function ($q2) use ($minDays) {
                                        $q2->whereNull('max_days')
                                             ->orWhere('max_days', '>=', $minDays);
                                   });
                         });
                    } else {
                         $query->where('min_days', '<=', $maxDays)
                         ->where(function ($q) use ($minDays) {
                              $q->whereNull('max_days')
                                   ->orWhere('max_days', '>=', $minDays);
                         });
                    }
               })
               ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId)) // untuk update
               ->exists();

          if ($overlap) {
               throw ValidationException::withMessages([
                    'min_days' => 'Range hari yang diinput overlap dengan data yang sudah ada.',
               ]);
          }
     }

     /**
          * Simpan data baru.
          */
     public function store(array $data): DoiPercentage
     {
          $this->checkOverlap($data['min_days'], $data['max_days'] ?? null);

          return DoiPercentage::create($data);
     }

     /**
          * Update data existing.
          */
     public function update(DoiPercentage $doiPercentage, array $data): DoiPercentage
     {
          $this->checkOverlap($data['min_days'], $data['max_days'] ?? null, $doiPercentage->id);

          $doiPercentage->update($data);

          return $doiPercentage->fresh();
     }

     /**
          * Hapus data.
          */
     public function destroy(DoiPercentage $doiPercentage): void
     {
          $doiPercentage->delete();
     }
}