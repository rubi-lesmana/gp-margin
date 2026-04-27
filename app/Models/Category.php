<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'status';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'status',
        'min_quantity',
        'max_quantity',
        'calculation',
    ];

    public function setCalculationAttribute($value)
    {
        $this->attributes['calculation'] = number_format($value / 100, 4, '.', '');  
    }

    public function getCalculationFormatAttribute($value)
    {
        return rtrim(
            rtrim(number_format($this->calculation * 100, 2, '.', ''), '0'), 
            '.'
        ) . '%';
    }
    
    public function getCalculationFormatedAttribute($value)
    {
        return rtrim(
            rtrim(number_format($this->calculation * 100, 2, '.', ''), '0'), 
            '.'
        );
    }

    /**
     * Tampilkan range quantity, jika max_quantity null tampilkan ">"
     */
    public function getRangeMaxQuantityAttribute(): string
    {
        if (is_null($this->max_quantity)) {
            return '> ' . $this->min_quantity;
        }

        return $this->min_quantity . ' - ' . $this->max_quantity;
    }
}