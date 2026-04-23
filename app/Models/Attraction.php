<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    protected $fillable = [
        'zone_id',
        'name',
        'description',
        'price_range',
        'image',
    ];
}
