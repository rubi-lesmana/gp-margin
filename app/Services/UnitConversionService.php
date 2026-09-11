<?php 

namespace App\Services;

use App\Models\UnitConversion;
use Illuminate\Support\Facades\DB;

class UnitConversionService
{
    protected string $prefix = 'UC-';
    protected int $padLength = 3;

    public function generateNextId(): string
    {
        $lastId = UnitConversion::where('id_unit_conversion', 'like', $this->prefix . '%')
            ->orderByRaw('CAST(SUBSTRING(id_unit_conversion, ' . (strlen($this->prefix) + 1) . ') AS UNSIGNED) DESC')
            ->value('id_unit_conversion');

        return $this->buildNextId($lastId);
    }

    /**
     * Generate ID berikutnya dengan row lock, dipakai di dalam transaction saat store().
     */
    protected function generateNextIdLocked(): string
    {
        $lastId = UnitConversion::where('id_unit_conversion', 'like', $this->prefix . '%')
            ->lockForUpdate()
            ->orderByRaw('CAST(SUBSTRING(id_unit_conversion, ' . (strlen($this->prefix) + 1) . ') AS UNSIGNED) DESC')
            ->value('id_unit_conversion');

        return $this->buildNextId($lastId);
    }

     protected function buildNextId(?string $lastId): string
    {
        if (!$lastId) {
            return $this->prefix . str_pad('1', $this->padLength, '0', STR_PAD_LEFT);
        }

        $lastNumber = (int) substr($lastId, strlen($this->prefix));
        $nextNumber = $lastNumber + 1;

        return $this->prefix . str_pad($nextNumber, $this->padLength, '0', STR_PAD_LEFT);
    }

    /**
     * Cek duplikat unit_id dalam satu payload sebelum disimpan.
     * Return array unit_id yang duplikat (kosong jika tidak ada).
     */
    public function findDuplicateUnits(array $unitIds): array
    {
        return array_diff_assoc($unitIds, array_unique($unitIds));
    }

    /**
     * Simpan unit_conversions beserta detail-nya dalam satu transaction.
     *
     * @param  array  $data  ['description' => string, 'unit_id' => array, 'conversion_value' => array]
     * @return UnitConversion
     */
    public function store(array $data): UnitConversion
    {
        return DB::transaction(function () use ($data) {
            $id = $this->generateNextIdLocked();

            $unitConversion = UnitConversion::create([
                'id_unit_conversion' => $id,
                'description'        => $data['description'],
            ]);

            $rows = [];
            foreach ($data['unit_id'] as $i => $unitId) {
                $rows[] = [
                    'unit_conversion_id' => $unitConversion->id_unit_conversion,
                    'unit_id'            => $unitId,
                    'conversion_value'   => $data['conversion_value'][$i],
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }

            DB::table('unit_conversion_details')->insert($rows);

            return $unitConversion;
        });
    }

    public function update(string $id, array $data): UnitConversion
    {
        return DB::transaction(function () use ($id, $data) {
            $unitConversion = UnitConversion::findOrFail($id);

            $unitConversion->update([
                'description' => $data['description'],
            ]);

            // Hapus semua detail lama
            DB::table('unit_conversion_details')
                ->where('unit_conversion_id', $unitConversion->id_unit_conversion)
                ->delete();

            // Insert ulang detail baru
            $rows = [];
            foreach ($data['unit_id'] as $i => $unitId) {
                $rows[] = [
                    'unit_conversion_id' => $unitConversion->id_unit_conversion,
                    'unit_id'            => $unitId,
                    'conversion_value'   => $data['conversion_value'][$i],
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }

            DB::table('unit_conversion_details')->insert($rows);

            return $unitConversion->fresh('details');
        });
    }

    public function destroy(string $id): void
    {
        DB::transaction(function () use ($id) {
            $unitConversion = UnitConversion::findOrFail($id);

            // Hapus semua detail terkait
            DB::table('unit_conversion_details')
                ->where('unit_conversion_id', $unitConversion->id_unit_conversion)
                ->delete();

            // Hapus unit conversion
            $unitConversion->delete();
        });
    }
}

?>