<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Stocks extends Model
{

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


    protected $fillable = ['book_id','user_id','main_store_quantity','grand_quantity','added','removed','description'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function book()
    {
        return $this->belongsTo(Books::class,'book_id','id');
    }

}
