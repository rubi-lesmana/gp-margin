<?php

// app/Models/SellingPrice.php

namespace App\Models;

use App\Traits\HasPricingPercentage;
use Illuminate\Database\Eloquent\Model;

class SellingPrice extends Model
{
    use HasPricingPercentage;

    protected $primaryKey = 'id_selling_price';
    public    $incrementing = false;
    protected $keyType      = 'string';

    protected $appends = [
        'base_margin_pct',
        'category_calc_pct',
        'top_percentage',
        'gp_margin_pct',
        'target_gp_pct',
    ];

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

    public function costPrice()
    {
        return $this->belongsTo(CostPrice::class, 'cost_price_id', 'id_cost_price');
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
}