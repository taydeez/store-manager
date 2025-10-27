<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use  HasFactory, Filterable;

    protected $fillable = ['name', 'phone', 'location', 'email'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }
}
