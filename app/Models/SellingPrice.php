<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellingPrice extends Model
{
    protected $table = 'vw_selling_price';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'item_id',
        'description',
        'margin_percentage',
        'category_status',
        'calculation',
        'gp_margin',
    ];

    protected $casts = [
        'margin_percentage' => 'float',
        'calculation'       => 'float',
        'gp_margin'         => 'float',
        'days'              => 'integer',
        'top_margin_pct'    => 'float',
        'target_gp'         => 'float',
    ];

    // Format gp_margin * 100 via accessor
    public function getGpMarginPercentAttribute(): string
    {
        return number_format($this->gp_margin * 100, 2) . '%';
    }

    // Format target_gp * 100 via accessor
    public function getTargetGpPercentAttribute(): string
    {
        return number_format($this->target_gp * 100, 2) . '%';
    }
}