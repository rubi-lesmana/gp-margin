<?php

namespace App\Services;

use App\Models\Arrival;
use App\Models\DoiPercentage;

class DoiService
{
     /**
     * Resolve DOI berdasarkan item_id
     * (1 row per item pada tabel arrival)
     */
    public function resolve(string $itemId): array
    {
        $arrival = Arrival::where('item_id', $itemId)->first();

        if (!$arrival) {
            return $this->buildResult(
                days        : 0,
                arrivalDate : null,
                status      : null,
                percentage  : 0.00,
                label       : 'Tidak ada data kedatangan'
            );
        }

        $days          = $arrival->getDaysOfInventory();
        $doiPercentage = DoiPercentage::findByDays($days);

        return $this->buildResult(
            days        : $days,
            arrivalDate : $arrival->date->toDateString(),
            status      : $arrival->status,             // Lokal / Import
            percentage  : (float) ($doiPercentage?->percentage ?? 0.00),
            label       : $doiPercentage?->label ?? '-'
        );
    }

    /**
     * Kurangi Target GP Margin dengan persentase DOI
     * Formula : TGP Margin - DOI Percentage
     */
    public function applyToTgpMargin(float $tgpMargin, string $itemId): array
    {
        $doi            = $this->resolve($itemId);
        $finalTgpMargin = $tgpMargin - $doi['percentage'];

        return [
            'doi'            => $doi,
            'tgp_before_doi' => $tgpMargin,
            'doi_deduction'  => $doi['percentage'],
            'final_tgp'      => $finalTgpMargin,
        ];
    }

    private function buildResult(
        int     $days,
        ?string $arrivalDate,
        ?string $status,
        float   $percentage,
        string  $label
    ): array {
        return [
            'days'         => $days,
            'arrival_date' => $arrivalDate,
            'status'       => $status,
            'percentage'   => $percentage,
            'label'        => $label,
        ];
    }
}

?>