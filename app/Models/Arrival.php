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
        'status', 'supplier_id',
        'currency_id',
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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id_supplier');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id_currency');
    }

    public function unit()
    {
        return $this->belongsTo(UnitConversionDetail::class, 'unit_id', 'unit_id');
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