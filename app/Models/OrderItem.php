<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */

    use HasFactory;

    protected $fillable = [
        'order_id', 'book_id', 'store_front_id', 'order_number', 'quantity', 'unit_price', 'sub_total', 'status'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function storeFront()
    {
        return $this->belongsTo(StoreFront::class, 'store_front_id', 'id');
    }

}
