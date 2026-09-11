<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitConversionDetail extends Model
{
    protected $table = 'unit_conversion_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'unit_conversion_id',
        'unit_id',
        'conversion_value',
        'created_at',
        'updated_at'
    ];

    public function unitConversion()
    {
        return $this->belongsTo(UnitConversion::class, 'unit_conversion_id', 'id_unit_conversion');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }
}
