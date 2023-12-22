<?php

namespace App\Models;

use App\Models\UnitPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstimateItem extends Model
{
    use HasFactory;

    protected $guarded = [];


    final public function prepareEstimateRecoredData($request, EstimateItem|null $estimateitem=null)
    {


        $data= [
            'estimate_id' => $request->input('estimate_id') ?? $estimateitem->estimate_id,
            'estimate_category_id' => $request->input('estimate_category_id') ?? $estimateitem->estimate_category_id,
            'estimate_sub_category_id' => $request->input('estimate_sub_category_id') ?? $estimateitem->estimate_sub_category_id,
            'type_id' => $request->input('type_id') ?? $estimateitem->type_id,
            'quantity' => $request->input('quantity') ?? $estimateitem->quantity,

            'unit_id' => $request->input('unit_id') ?? $estimateitem->unit_id,
        ];
        return $data;
    
    }


    final public function createEstimateRecord(array $data)
    {
        return self::create($data);
    }

    final public function updateEstimateRecord(array $data, EstimateItem $estimate)
    {
        return $estimate->update($data);
    }

    final public function deleteEstimateRecord(EstimateItem $estimate)
    {
        return $estimate->delete();
    }


    public function estimateCategory()
    {
        return $this->belongsTo(EstimateCategory::class, 'estimate_category_id', 'id');
    }

    public function estimateSubCategory()
    {
        return $this->belongsTo(EstimateCategory::class, 'estimate_sub_category_id', 'id');
    }


}
