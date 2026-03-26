<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggest extends Model
{
    protected $table        = 'suggests';
    protected $primaryKey   = 'id_suggest';
    public $incrementing    = false;
    protected $keyType      = 'string';

    protected $fillable = [
        'id_suggest',
        'item_id',
        'quantity',
        'cost_price',
        'top',
        'keterangan',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}
