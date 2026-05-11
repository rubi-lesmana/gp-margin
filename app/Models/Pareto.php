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

    // Relasi ke Tabel Item
    public function items()
    {
        return $this->belongsTo(Item::class, 'pareto_id', 'id');
    }
}