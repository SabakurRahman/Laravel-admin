<?php

namespace App\Models;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

class AttributeValue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;
    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    final public function prepareAttributeValue($requst, AttributeValue|null $attributevalue=null)
    {
        return [
            'name' => $requst->input('name')??$attributevalue->name,
            'name_bn' => $requst->input('name_bn')??$attributevalue->name_bn,
            'display_order' => $requst->input('display_order')??$attributevalue->display_order,
            'status' => $requst->input('status')??$attributevalue->status,
            'attribute_id' => $requst->input('attribute_id')??$attributevalue->attribute_id,
        ];
    }



    final public function updateAttributeValue(array $data, AttributeValue $attributevalue)
    {
         $attributevalue->update($data);
         return $attributevalue;
    }
    final public function createAttributeValue(array $data)
    {
        return AttributeValue::create($data);
    }

    final public function deleteAttributeValue(AttributeValue $attributevalue)
    {
        return $attributevalue->delete();
    }

    final public function getAttributeValueList(Request $request)
    {
        $paginate = $request->input('per_page') ?? 10;
        $query    = self::query();
        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->input('name_bn')) {
            $query->where('name_bn', 'like', '%' . $request->input('name_bn') . '%');
        }
        if ($request->input('attribute_id')) {
            $query->where('attribute_id', 'like', '%' . $request->input('attribute_id') . '%');
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

    final public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    //   final public function attribute()
    // {
    //     return $this->belongsTo(ProductAttributes::class);
    // }
   public function product_attribute()
    {
        return $this->belongsTo(ProductAttributes::class);
    }

    final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

}
