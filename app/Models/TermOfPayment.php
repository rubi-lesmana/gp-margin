<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermOfPayment extends Model
{
    protected $fillable = [
        'id',
        'days',
        'description',
    ];

}