<?php

namespace App\Services;

use App\Models\Arrival;

class ArrivalService
{
    /**
     * Generate ID baru dengan format ARR-XXXX berdasarkan ID terakhir.
     */
    public function generateNextId(): string
    {
        $lastArrival = Arrival::orderBy('id', 'desc')->first();

        $nextNumber = $lastArrival
            ? (int) substr($lastArrival->id, 4) + 1
            : 1;

        return 'ARR-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Simpan data arrival baru dari data yang sudah tervalidasi.
     */
    public function create(array $validated): Arrival
    {
        return Arrival::create([
            'id'            => $this->generateNextId(),
            'item_id'       => $validated['item_id'],
            'status'        => $validated['status'],
            'supplier_id'   => $validated['supplier_id'],
            'currency_id'   => $validated['currency_id'],
            'quantity'      => $validated['quantity'],
            'date'          => $validated['date'],
            'keterangan'    => $validated['keterangan'] ?? null,
            'unit_id'       => $validated['unit_id'],
            'unit_price'    => $validated['unit_price'],
            'net_amount'    => $validated['net_amount'],
        ]);
    }

    /**
     * Update data arrival (item_id tidak diubah, tetap sesuai data lama).
     */
    public function update(Arrival $arrival, array $validated): Arrival
    {
        $arrival->update([
            'status'        => $validated['status'],
            'supplier_id'   => $validated['supplier_id'],
            'currency_id'   => $validated['currency_id'],
            'quantity'      => $validated['quantity'],
            'date'          => $validated['date'],
            'keterangan'    => $validated['keterangan'] ?? null,
            'unit_id'       => $validated['unit_id'],
            'unit_price'    => $validated['unit_price'],
            'net_amount'    => $validated['net_amount'],
        ]);

        return $arrival;
    }
}