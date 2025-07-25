<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiClient extends Model
{
    protected $table = 'api_clients';
    protected $fillable = ['domain','api_key','expires_in'];
}
