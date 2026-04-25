<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arrival extends Model
{
    protected $table = 'arrival';

    protected $fillable = [
        'item_id',
        'status',
        'quantity',
        'date',
        'keterangan',
    ];

    protected $casts = [
        'date' => 'datetime',
        'quantity' => 'integer',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
    
    /**
     * Hitung selisih hari dari tanggal kedatangan sampai hari ini
     */
    public function getDaysOfInventory(): int
    {
        return (int) $this->date->diffInDays(now());
    }
    
}