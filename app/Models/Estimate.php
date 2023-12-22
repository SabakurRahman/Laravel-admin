<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class Estimate extends Model
{
    use HasFactory;

    protected $guarded = [];

    final public function prepareEstimateData($request, Estimate|null $estimate = null)
    {
        $data = [
            'name' => $request->input('name') ?? $estimate->name??'',
            'phone' => $request->input('phone') ?? $estimate->phone??'',
            'email' => $request->input('email') ?? $estimate->email??'',
        ];
        return $data;
    }

    final public function createEstimate(array $data)
    {
        return self::create($data);
    }
}
