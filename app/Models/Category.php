<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'status',
        'quantity',
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
}