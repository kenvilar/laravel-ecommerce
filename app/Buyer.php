<?php

namespace App;

use App\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BuyerScope);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
