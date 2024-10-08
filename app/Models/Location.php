<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'country',
        'city',
        'street',
        'postcode'
    ];
}
