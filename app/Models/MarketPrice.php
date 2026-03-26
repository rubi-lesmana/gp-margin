<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    protected $table = 'market_price';

    protected $fillable = [
        'item_id',
        'price',
        'keterangan',
    ];

    public function getSafeItemIdAttribute($value)
    {
        return str_replace('.', '_', $value);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}
