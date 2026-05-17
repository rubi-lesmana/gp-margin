<?php

namespace App\Traits;

trait HasPricingPercentage
{
    public function getBaseMarginPctAttribute(): string
    {
        return round($this->base_margin_snapshot * 100, 2) . '%';
    }

    public function getCategoryCalcPctAttribute(): string
    {
        return round($this->category_calc_snapshot * 100, 2) . '%';
    }

    public function getTopPercentageAttribute(): string
    {
        return round($this->top_pct_snapshot * 100, 2) . '%';
    }

    public function getGpMarginPctAttribute(): string
    {
        return round($this->gp_margin * 100, 2) . '%';
    }

    public function getTargetGpPctAttribute(): string
    {
        return round($this->target_gp * 100, 4) . '%';
    }
}

?>