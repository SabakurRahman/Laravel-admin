<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

        public function getPaymentMethodList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query    = self::query()->with(['user']);
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('account_no')){
            $query->where('account_no', 'like', '%'.$request->input('account_no').'%');
        }
        if ($request->input('status')){
            $query->where('status', $request->input('status'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

     public function createNewPaymentMethod(StorePaymentMethodRequest $request)
    {
        return self::query()->create($this->prepareNewPaymentMethodData($request));
    }

    private function prepareNewPaymentMethodData(StorePaymentMethodRequest $request)
    {
        return[
            'name'   => $request->input('name'),
            'status' => $request->input('status'),
            'account_no' => $request->input('account_no'),
            'user_id' => Auth::id(),

        ];
    }

    public function updatePaymentMethodInfo(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        $updatePaymentMethodInfoData = [
            'name'   => $request->input('name')   ?? $paymentMethod->name,
            'status' => $request->input('status') ?? $paymentMethod->status,
            'account_no' => $request->input('account_no') ?? $paymentMethod->account_no,
            'user_id' => Auth::id()
        ];

        $paymentMethod->update($updatePaymentMethodInfoData);

        return $paymentMethod;

    //   return $paymentMethod->update($updatePaymentMethodInfoData);

    }
       public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    // public function seos(){
    //     return $this->morphOne(Seo::class, 'seoable');
    // }
        public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphMany
     */
    final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

    public function getPaymentMethodName()
    {
        return self::all();
    }


}




