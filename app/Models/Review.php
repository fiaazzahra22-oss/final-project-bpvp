<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'attraction_id',
        'reviewer',
        'description',
        'rating'
    ];
}