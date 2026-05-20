<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'item_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'item_id',
        'description',
        'base_margin_id',
        'unit_id',
        'pareto_id',
    ];

    public function base_margin()
    {
        return $this->hasOne(BaseMargin::class, 'id', 'base_margin_id');
    }

    // Relasi ke Tabel Unit
    public function unit()
    {
        return $this->hasOne(Unit::class, 'unit_id', 'unit_id');
    }

    // Relasi ke Tabel Pareto
    public function pareto()
    {
        return $this->hasOne(Pareto::class, 'id', 'pareto_id');
    }

    // Relasi ke Master Item
    public function cost_price()
    {
        return $this->hasMany(CostPrice::class, 'item_id', 'item_id');
    }

    // Method accessor yang berfungsi untuk mengganti karakter titik (.) dengan underscore (_)
    // Pemanggilan blade: $item->safe_item_id
    public function  getSafeItemIdAttribute(){
        return str_replace('.', '_', $this->item_id);
    }

    public function marketPrices()
    {
        return $this->hasMany(MarketPrice::class, 'item_id', 'item_id');
    }

    public function arrivals()
    {
        return $this->hasMany(Arrival::class, 'item_id', 'item_id');
    }

    public function suggests()
    {
        return $this->hasMany(Suggest::class, 'item_id', 'item_id');
    }

    public function marketPriceDetails()
    {
        return $this->hasMany(MarketPriceDetail::class, 'item_id', 'item_id');
    }

    public function sellingPrices()
    {
        return $this->hasMany(SellingPrice::class, 'item_id', 'item_id');
    }

    public function itemHistories()
    {
        return $this->hasMany(ItemHistory::class, 'item_id', 'item_id');
    }
}