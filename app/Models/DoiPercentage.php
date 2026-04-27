<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoiPercentage extends Model
{
    protected $table = 'doi_percentages';

    protected $fillable = [
        'min_days', 'max_days', 'percentage', 'label',
    ];

    protected $casts = [
        'min_days' => 'integer',
        'max_days' => 'integer',
        'percentage' => 'decimal:2',
    ];

    /**
     * Cari persentase berdasarkan jumlah hari DOI
     */

    public static function findByDays($days)
    {
        return self::where('min_days', '<=', $days)
            ->where(function ($query) use ($days) {
                // max_days NULL berarti tidak ada batas atas
                $query->whereNull('max_days')
                      ->orWhere('max_days', '>=', $days);
            })
            ->orderBy('min_days', 'desc')
            ->first();
    }

    /**
     * Menambahkan kata hari dalam min days
     */
    public function getMinDaysFormatAttribute()    {
        return $this->min_days . ' hari';
    }

    /**
     * Tampilkan range days, jika max_days null tampilkan ">"
     */
    public function getRangeMaxDaysAttribute(): string
    {
        if (is_null($this->max_days)) {
            return '> ' . $this->min_days . ' hari';
        }

        return $this->min_days . ' - ' . $this->max_days . ' hari';
    }
}