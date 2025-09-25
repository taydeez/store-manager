<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use App\Casts\BooleanStringCast;
use Illuminate\Database\Eloquent\Model;

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


}
