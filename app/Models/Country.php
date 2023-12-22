<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $guarded = [];

    final public function getAllCountry()
    {
        return $this->orderBy('id', 'desc')->get();
    }

    final public function getCountryById($id)
    {
        return $this->where('id', $id)->first();
    }
}
