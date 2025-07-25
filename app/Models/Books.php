<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{

    use Filterable;
    protected $fillable = ['added_by','title','quantity','price','tags','available'];

}
