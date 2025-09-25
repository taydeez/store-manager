<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{

    protected $fillable = ['book_id','user_id','quantity','added','removed','description'];



}
