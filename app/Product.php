<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'quantity',
        'status',
        'image',
    ];
}
