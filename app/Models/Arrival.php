<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arrival extends Model
{
    protected $table = 'arrival';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'item_id',
        'status',
        'quantity',
        'date',
        'keterangan',
        'unit_id',
        'unit_price',
        'net_amount',
    ];

    protected $casts = [
        // 'date' => 'datetime',
        'quantity' => 'integer',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function cost_price()
    {
        return $this->hasOne(CostPrice::class, 'arrival_id', 'id');
    }
    
    /**
     * Hitung selisih hari dari tanggal kedatangan sampai hari ini
     */
    public function getDaysOfInventory(): int
    {
        return (int) $this->date->diffInDays(now());
    }
    
}