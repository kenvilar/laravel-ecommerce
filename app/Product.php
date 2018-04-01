<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const AVAILABLE = 'available';
    const UNAVAILABLE = 'unavailable';

    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'quantity',
        'status',
        'image',
    ];

    public function isAvailable()
    {
        return $this->status = Product::AVAILABLE;
    }
}
