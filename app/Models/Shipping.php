<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const RESIDENTIAL_INTERIOR = 1;
    public const COMMERCIAL_INTERIOR = 2;
    public const FURNITURE = 3;
    public const CUSTOM_LIGHTS = 4;

    public const PRODUCT_TYPE_LIST = [
        self::RESIDENTIAL_INTERIOR => 'Residential Interior',
        self::COMMERCIAL_INTERIOR  => 'commercial Interior',
        self::FURNITURE            => 'Furniture',
        self::CUSTOM_LIGHTS        => 'Custom Lights',
    ];
        public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
