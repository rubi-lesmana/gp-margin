<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id_customer';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_customer',
        'name',
    ];

    public function getSafeCustomerIdAttribute()
    {
        return str_replace('.', '_', $this->id_customer);
    }
}