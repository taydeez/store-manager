<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_front_id', 'book_id', 'book_quantity', 'stocked_quantity', 'is_available', 'admin_disabled'
    ];


    public function storefront()
    {
        return $this->belongsTo(StoreFront::class, 'store_front_id', 'id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
