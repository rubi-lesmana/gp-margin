<?php

// app/Models/SellingPriceDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellingPriceDetail extends Model
{
    protected $fillable = [
        'selling_price_id',
        'base_margin_id',
        'base_margin_snapshot',
        'category_status',
        'category_calc_snapshot',
        'gp_margin',
        'term_of_payment_id',
        'top_days_snapshot',
        'tgp_margin_id',
        'top_pct_snapshot',
        'target_gp',
        'adj_gp_margin_price',
        'suggested_selling_price',
        'ssp_basis',
        'status',
    ];

    public function sellingPrice()
    {
        return $this->belongsTo(SellingPrice::class, 'selling_price_id', 'id_selling_price');
    }
}