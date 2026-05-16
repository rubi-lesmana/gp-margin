<?php

// app/Models/SellingPrice.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellingPrice extends Model
{
    protected $primaryKey = 'id_selling_price';
    public    $incrementing = false;
    protected $keyType      = 'string';

    protected $fillable = [
        'id_selling_price',
        'item_id',
        'cost_price_id',
        'cost_price_snapshot',
        'market_price_detail_id',
        'market_price_snapshot',
        'status',
        'calculated_by',
        'approved_by',
        'calculated_at',
        'approved_at',
    ];

    protected $casts = [
        'calculated_at' => 'datetime',
        'approved_at'   => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(SellingPriceDetail::class, 'selling_price_id', 'id_selling_price');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}