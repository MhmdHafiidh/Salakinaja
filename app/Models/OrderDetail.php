<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'order_details';

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id');
    }
}
