<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UnitPriceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcessDataResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'status' => true,
            'data' => $this->transformData($this->resource),
        ];
    }

    protected function transformData($data)
    {
        $result = [];

        foreach ($data as $key => $items) {
            $result[] = [
                $key => UnitPriceResource::collection($items),
            ];
        }

        return $result;
    }
}