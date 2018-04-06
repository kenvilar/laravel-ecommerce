<?php

namespace App;

use App\Scopes\SellerScope;
use App\Transformers\SellerTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends User
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $transformer = SellerTransformer::class;

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
