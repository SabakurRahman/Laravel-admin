<?php

namespace App\Models;

use App\Http\Requests\StoreOrderRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    public const TRANSACTION_CREDIT = 1;
    public const TRANSACTION_DEBIT = 2;

    public const TRANSACTION_TYPE_LIST = [
        self::TRANSACTION_CREDIT => 'Credit',
        self::TRANSACTION_DEBIT  => 'Debit',
    ];

    public const STATUS_SUCCESS = 1;

    public const STATUS_FAILED = 2;


    public const STATUS_LIST =
        [
            self::STATUS_SUCCESS => 'Success',
            self::STATUS_FAILED  => 'Failed',
        ];

    public function store_order_transaction(Request|StoreOrderRequest $request, Model|Builder $order)
    {
        return self::query()->create($this->prepareTransactionData($request, $order));

    }

    private function prepareTransactionData(Request|StoreOrderRequest $request, Model|Builder $order)
    {
        return [
            'user_id'           => Auth::id(),
            'payment_method_id' => $request->payment_method_id,
            'order_id'          => $order?->id,
            'trx_id'            => $request->trx_id,
            'amount'            => !empty($request->sub_total) ? $request->sub_total : $order->total_payable_amount,
            'transaction_type'  => self::TRANSACTION_CREDIT,
            'status'            => self::STATUS_SUCCESS,
        ];
    }

<<<<<<< HEAD

    /**
     * @return MorphTo
     */
    final public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

=======
     final public function payment_method()
    {
        return $this->hasMany(PaymentMethod::class,'payment_method_id','id');
    }
>>>>>>> d615f4637c12e9de32295a4c2335c75b5bf5ab95
}
