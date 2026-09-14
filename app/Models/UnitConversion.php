<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitConversion extends Model
{
    protected $table = 'unit_conversions';
    protected $primaryKey = 'id_unit_conversion';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_unit_conversion',
        'description',
        'created_at',
        'updated_at'
    ];

    public function details()
    {
        return $this->hasMany(UnitConversionDetail::class, 'unit_conversion_id', 'id_unit_conversion');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'unit_conversion_id', 'id_unit_conversion');
    }
}
