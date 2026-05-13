<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPriceDetail extends Model
{
    protected $table = 'market_price_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'market_price_id',
        'item_id',
        'price',
    ];

    public function marketPrice()
    {
        return $this->belongsTo(MarketPrice::class, 'market_price_id', 'id_market_price');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}