<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warrenty extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const EXPRESSED = 1;
    public const IMPLIED   = 2;

    public const WARRENTY_TYPE_LIST = [
        self::EXPRESSED => 'Expressed',
        self::IMPLIED   => 'Implied',
    ];

    public const THREE_MONTH = 1;
    public const SIX_MONTH   = 2;
    public const ONE_YEAR    = 3;

    public const WARRENTY_PERIOD_LIST = [
        self::THREE_MONTH => '3 Month',
        self::SIX_MONTH   => '6 Month',
        self::ONE_YEAR    => '1 Year',
    ];


        public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
