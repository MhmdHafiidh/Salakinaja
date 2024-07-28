<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id');
    }
}
