<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;
    protected $guarded = [];

        public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'variation_id');
    }


     public function productVariationPhoto()
    {
        return $this->hasOne(ProductPhoto::class, 'variation_id', 'id');
    }

    public function variationAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'variation_id', 'id');
    }

    public function productPrice()
    {
        return $this->hasOne(ProductPrice::class, 'variation_id', 'id');
    }
    public function productInventory()
    {
        return $this->hasOne(Inventory::class, 'variation_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productPhotos()
    {
        return $this->hasMany(ProductPhoto::class, 'variation_id');
    }

    // public function lastWholesalePrice()
    // {
    //     return $this->hasOne(ProductRetailSale::class, 'variation_id', 'id')->latest();
    // }
}
