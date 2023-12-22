<?php

namespace App\Models;

use App\Http\Requests\StoreCustomerGroupRequest;
use App\Http\Requests\UpdateCustomerGroupRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    use HasFactory;
    protected $guarded=[];

    public const STATUS_ACTIVE =1;
    public const STATUS_INACTIVE =2;
    public const STATUS_LIST =[
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive'

    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function storeCustomerGroup(StoreCustomerGroupRequest $request)
    {
        return self::query()->create($this->preparedCustomerGroupData($request));
    }

    private function preparedCustomerGroupData(StoreCustomerGroupRequest $request)
    {
        return [
            'name'              =>$request->input('name'),
            'status'            =>$request->input('status'),
            'discount_percent'  =>$request->input('discount_percent'),
            'discount_fixed'    =>$request->input('discount_fixed')
        ];
    }

    public function allCustomerGroupList()
    {
        return self::all();
    }

    public function updateCustomerGroup(UpdateCustomerGroupRequest $request, CustomerGroup $customerGroup)
    {
        $data =[
            'name'              =>$request->input('name') ?? $customerGroup->name,
            'status'            =>$request->input('status') ?? $customerGroup->status,
            'discount_percent'  =>$request->input('discount_percent') ?? $customerGroup->discount_percent,
            'discount_fixed'    =>$request->input('discount_fixed') ?? $customerGroup->discount_percent
        ];

       return $customerGroup->update($data);

    }
}
