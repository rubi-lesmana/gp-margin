<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TgpMargin extends Model
{
    protected $table = 'tgp_margins';
    protected $fillable = [
        'id',
        'margin_percentage',
    ];

    // Fungsi Accesor untuk mendapatkan nilai margin_percentage dalam format persentase
    // Misalnya, jika disimpan 10%, maka akan disave dengan 0.10
    public function setMarginPercentageAttribute($value)
    {
        $this->attributes['margin_percentage'] = number_format($value / 100, 4, '.', '');  
    }

    public function getMarginPercentageFormatAttribute($value)
    {
        return rtrim(
            rtrim(number_format($this->margin_percentage * 100, 2, '.', ''), '0'), 
            '.'
        ) . '%';
    }

    public function getMarginPercentageFormatedAttribute($value)
    {
        return rtrim(
            rtrim(number_format($this->margin_percentage * 100, 2, '.', ''), '0'), 
            '.'
        );
    }
}