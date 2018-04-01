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

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
