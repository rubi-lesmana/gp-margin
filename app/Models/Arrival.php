<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arrival extends Model
{
    protected $table = 'arrival';

    protected $fillable = [
        'item_id',
        'status',
        'quantity',
        'date',
        'keterangan',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}
