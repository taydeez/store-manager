<?php

namespace App\Models;

use App\Casts\BooleanStringCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreFront extends Model
{
    //

    /** @use HasFactory<\Database\Factories\StoreFrontFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['store_name','store_address', 'store_phone', 'store_email','is_active','store_city','store_country','user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'is_active' => BooleanStringCast::class,
    ];


}
