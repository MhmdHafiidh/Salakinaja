<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
