<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesProposalDetail extends Model
{
    protected $primaryKey  = 'id';
    protected $fillable = [
        'proposal_id', 'item_id', 'selling_price_id', 'qty',
        'ssp_min_snapshot', 'ssp_max_snapshot',
        'proposed_price', 'price_diff', 'price_diff_pct',
        'price_position', 'is_below_ssp',
    ];

    protected $casts = [
        'is_below_ssp' => 'boolean',
    ];
    
    public function sales_proposal()
    {
        return $this->belongsTo(SalesProposal::class, 'proposal_id', 'id_proposal');
    }

    public function selling_price()
    {
        return $this->belongsTo(SellingPrice::class, 'selling_price_id', 'id_selling_price');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}