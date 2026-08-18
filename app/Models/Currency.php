<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';
    protected $primaryKey = 'id_currency';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_currency',
        'description',
    ];
}
