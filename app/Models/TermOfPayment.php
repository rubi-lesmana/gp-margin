<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermOfPayment extends Model
{
    protected $fillable = [
        'id',
        'days',
        'description',
        'percent_id',
    ];

    public function tgp_margins()
    {
        return $this->belongsTo(TgpMargin::class, 'percent_id', 'id');
    }
}