<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellingPriceDraft extends Model
{
    protected $table = 'vw_selling_price_draft';
    public $timestamps = false;

    // Cast nilai desimal → persen untuk ditampilkan
    // 0.0800 → "8%", 1.25 → "125%", 0.07 → "7%"
    protected $appends = [
        'base_margin_pct',
        'category_calc_pct',
        'top_pct',
        'target_gp_pct',
        'gp_margin_pct',
    ];

    public function getBaseMarginPctAttribute(): string
    {
        return number_format($this->base_margin_snapshot * 100, 2) . '%';
    }

    public function getCategoryCalcPctAttribute(): string
    {
        return number_format($this->category_calc_snapshot * 100, 2) . '%';
    }

    public function getTopPctAttribute(): string
    {
        return number_format($this->top_pct_snapshot * 100, 2) . '%';
    }

    public function getGpMarginPctAttribute(): string
    {
        return number_format($this->gp_margin * 100, 2) . '%';
    }

    public function getTargetGpPctAttribute(): string
    {
        return number_format($this->target_gp * 100, 2) . '%';
    }
}