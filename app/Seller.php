<?php

namespace App;

use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SellerScope);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
