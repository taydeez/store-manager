<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Customer extends Model
{

    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use  HasFactory, Filterable;

    protected $fillable = ['name', 'phone', 'location', 'email'];

    protected static function booted()
    {
        static::saved(function ($customer) {
            Cache::forget('customer_' . $customer->phone);
        });

        static::deleted(function ($customer) {
            Cache::forget('customer_' . $customer->phone);
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }
}
