<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $primaryKey = 'unit_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'unit_id',
        'description',
    ];

    // Relasi ke Tabel Item
    public function items()
    {
        return $this->belongsTo(Item::class, 'unit_id', 'unit_id');
    }
}