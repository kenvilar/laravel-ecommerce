<?php

namespace App;

use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    const AVAILABLE = 'available';
    const UNAVAILABLE = 'unavailable';

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'quantity',
        'status',
        'image',
    ];

    protected $hidden = ['pivot'];

    public $transformer = ProductTransformer::class;

    public function isAvailable()
    {
        return $this->status == Product::AVAILABLE;
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
