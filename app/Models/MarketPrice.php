<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    protected $table = 'market_price';
    protected $primaryKey = 'id_market_price';
    protected $keyType = 'string';

    protected $fillable = [
        'id_market_price',
        'effective_date',
        'keterangan',
    ];

    // public function getSafeItemIdAttribute($value)
    // {
    //     return str_replace('.', '_', $value);
    // }

    // public function item()
    // {
    //     return $this->belongsTo(Item::class, 'item_id', 'item_id');
    // }
}