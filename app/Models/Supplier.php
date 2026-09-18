<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id_supplier';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_supplier',
        'supplier_name',
        'address',
        'country',
    ];

    public function getSafeSupplierIdAttribute()
    {
        return str_replace('.', '_', $this->id_supplier);
    }

    public function arrivals()
    {
        return $this->hasMany(Arrival::class, 'supplier_id', 'id_supplier');
    }
}
