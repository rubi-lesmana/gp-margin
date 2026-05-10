<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pareto extends Model
{

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'description',
    ];
}