<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use App\Casts\BooleanStringCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Books extends Model
{
    use Filterable;


    protected $fillable = ['added_by','title','quantity','price','tags','available','image_url'];

    protected $hidden = ['image_url','deleted_at','updated_at'];

    protected $appends = ['photo']; // 👈 auto-include in JSON

    public function getPhotoAttribute()
    {
        return $this->image_url
            ? asset('storage/' . $this->image_url)
            : null;
    }


    protected $casts = [
        'tags' => 'array',
        'available' => BooleanStringCast::class,
    ];


    public function stocks()
    {
        return $this->hasMany(Stocks::class,'book_id','id');
    }


    public function latestStock()
    {
      return  $this->hasOne('App\Models\Stocks','book_id','id')->latestOfMany();
    }



    /**
     * Safely update stock for this book.
     *
     * @param int $add
     * @param int $remove
     * @param string $description
     * @return \App\Models\Book
     */
    public function updateStock(int $add = 0, int $remove = 0, string $description = 'update book stock')
    {
        return DB::transaction(function () use ($add, $remove, $description) {
            // Get latest stock snapshot
            $stock = $this->stocks()->latest()->first();

            $main_value  = $stock?->main_store_quantity ?? 0;
            $grand_value = $stock?->grand_quantity ?? 0;

            if ($add > 0) {
                $main_value  += $add;
                $grand_value += $add;
            } elseif ($remove > 0) {
                $main_value  -= $remove;
                $grand_value -= $remove;

                if ($main_value < 0 || $grand_value < 0) {
                    throw new \Exception("Stock quantity cannot be negative.");
                }
            }

            // Save new stock history record
            $this->stocks()->create([
                'added'               => $add,
                'removed'             => $remove,
                'main_store_quantity' => $main_value,
                'grand_quantity'      => $grand_value,
                'description'         => $description,
                'book_id'             => $this->id,
            ]);

            // Update book’s current quantity
            $this->update([
                'quantity' => $main_value,
            ]);

            return $this;
        });
    }

}
