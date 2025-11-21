<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use SoftDeletes, HasFactory;

    public static function boot()
    {
        parent::boot();

        // Automatically set user_id when creating
        static::creating(function ($stock) {
            if (Auth::check()) {
                $stock->user_id = Auth::id();
            }
        });
    }


    protected $fillable = [
        'book_id', 'user_id', 'main_store_quantity', 'grand_quantity', 'added', 'removed', 'description'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

}
