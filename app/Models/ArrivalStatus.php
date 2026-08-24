<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArrivalStatus extends Model
{
    protected $table = 'arrival_statuses';
    protected $fillable = [
        'code',
        'description',
        'default_currency_id'
    ];

    public function defaultCurrency()
    {
        return $this->belongsTo(Currency::class, 'default_currency_id');
    }
}
