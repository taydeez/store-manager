<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */

    use HasFactory, Filterable;

    protected $fillable = [
        'customer_id', 'store_front_id', 'sold_by_id', 'order_number', 'status', 'total_amount'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function storeFront()
    {
        return $this->belongsTo(StoreFront::class, 'store_front_id', 'id');
    }


}
