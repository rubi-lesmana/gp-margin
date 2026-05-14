<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostPrice extends Model
{
    protected $table        = 'cost_prices';
    protected $primaryKey   = 'id_cost_price';
    public $incrementing    = false;
    protected $keyType      = 'string';

    protected $fillable = [
        'id_cost_price',
        'arrival_id',
        'item_id',
        'date',
        'cost_price',
        'manual_reference'
    ];

    public function arrival()
    {
        return $this->belongsTo(Arrival::class, 'arrival_id', 'id');
    }

    public function item(){
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}