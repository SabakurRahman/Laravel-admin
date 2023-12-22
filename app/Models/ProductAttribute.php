<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = ['product_id', 'variation_id', 'attribute_id', 'value'];

    final public function storeProductAttributData(Request $request, Model|Product $product): void
    {
        foreach ($request->input('attribute') as $attribute) {
            if (!empty($attribute['value'])) {
                self::query()->create($this->prepareProductAttributeData($attribute, $product));
            }
        }
    }

    /**
     * @param array $attribute
     * @param Model|Product $product
     * @return array
     */
    private function prepareProductAttributeData(array $attribute, Model|Product $product): array
    {
        return [
            'product_id'   => $product->id,
            'variation_id' => null,
            'attribute_id' => $attribute['attribute_id'] ?? null,
            'value'        => $attribute['value'] ?? null,
        ];
    }

    public function productAttribute()
    {
        return $this->belongsTo(__CLASS__);
    }

    public function AttributeName()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }
}
