<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemAttribute extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function order_items()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
