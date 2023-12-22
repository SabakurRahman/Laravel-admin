<?php

namespace App\Models;

use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Order extends Model
{
    use HasFactory;

    protected $guarded = [];


    public const SHIPPING_STATUS_PENDING = 1;
    public const SHIPPING_STATUS_SHIPPED = 2;

    public const SHIPPING_STATUS_LIST = [

        self::SHIPPING_STATUS_PENDING => 'Pending',
        self::SHIPPING_STATUS_SHIPPED => 'Shipped',
    ];

    public const ORDER_STATUS_PENDING = 1;
    public const ORDER_STATUS_PROCESSING = 2;
    public const ORDER_STATUS_CALL_WAITING = 3;
    public const ORDER_STATUS_NEED_EXPERT_CALL = 4;
    public const ORDER_STATUS_OFFICE_PICKUP = 5;
    public const ORDER_STATUS_CANCEL = 6;
    public const ORDER_STATUS_SCHEDULED = 7;
    public const ORDER_STATUS_ON_HOLD = 8;


    public const ORDER_STATUS_LIST = [
        self::ORDER_STATUS_PENDING          => 'Pending',
        self::ORDER_STATUS_PROCESSING       => 'Processing',
        self::ORDER_STATUS_CALL_WAITING     => 'Call Waiting',
        self::ORDER_STATUS_NEED_EXPERT_CALL => 'Need Expert Call',
        self::ORDER_STATUS_OFFICE_PICKUP    => 'Office Pickup',
        self::ORDER_STATUS_CANCEL           => 'Cancel',
        self::ORDER_STATUS_SCHEDULED        => 'Scheduled',
        self::ORDER_STATUS_ON_HOLD          => 'On Hold',
    ];

    public const ORDER_FROM_CUSTOMER = 1;
    public const ORDER_FROM_ADMIN = 2;
    public const ORDER_PROCESS = 8;
    public const ORDER_PICKUP = 9;
    public const  ORDER_CANCEL = 10;
    public const NEXT_EXPERT_CALL = 11;

    public const SHIPPING_LOCATION_DHAKA = 1;
    public const  SHIPPING_LOCATION_OUTSIDE_DHAKA = 2;

    public const SHIPPING_LOCATION_LIST = [
        self::SHIPPING_LOCATION_DHAKA         => 'Inside Dhaka',
        self::SHIPPING_LOCATION_OUTSIDE_DHAKA => 'Outside Dhaka'
    ];


    public const PAYMENT_STATUS_PAID = 1;
    public const PAYMENT_STATUS_UNPAID = 2;
    public const PAYMENT_STATUS_PARTIALLY_PAID = 3;

    public const PAYMENT_STATUS_LIST = [
        self::PAYMENT_STATUS_PAID           => 'Paid',
        self::PAYMENT_STATUS_UNPAID         => 'Unpaid',
        self::PAYMENT_STATUS_PARTIALLY_PAID => 'Partial'

    ];


    public function allOrderList(Request $request)
    {


        $paginate = $request->input('per_page') ?? 10;
        $query    = self::query()->with('order_items.product', 'orderaddress', 'orderaddress.cities', 'user.roles');
        if ($request->input('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->input('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }


        if ($request->input('invoice_no')) {
            $query->where('invoice_no', 'like', '%' . $request->input('invoice_no') . '%');
        }
        if ($request->input('order_status')) {
            $query->where('order_status', $request->input('order_status'));
        }
        if ($request->input('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }
        if ($request->input('shipping_status')) {
            $query->where('shipping_status', $request->input('shipping_status'));
        }

        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);


    }

    public function getOrderCounts()
    {
        return [
            'allOrders'       => self::query()->count(),
            'orderStatus'     => self::query()->where('order_status', self::ORDER_STATUS_PENDING)->count(),
            'paymentPending'  => self::query()->where('payment_status', self::PAYMENT_STATUS_UNPAID)->count(),
            'orderProcessing' => self::query()->where('order_status', self::ORDER_STATUS_PROCESSING)->count(),
            'nextExpertCall'  => self::query()->where('order_status', self::ORDER_STATUS_NEED_EXPERT_CALL)->count(),
            'orderPickup'     => self::query()->where('order_status', self::ORDER_STATUS_OFFICE_PICKUP)->count(),
        ];
    }

    public function cancelOrder($order_id)
    {
        $order = self::find($order_id);

        $data = [
            'order_status' => self::ORDER_CANCEL
        ];
        return $order->update($data);
    }


    public function changeOrderStatus($request, $order_id)
    {
        $order = self::find($order_id);
        $data  = [
            'order_status' => $request->order_status
        ];
        return $order->update($data);

    }

    public function changeShippingStatus(Request $request, $order_id)
    {
        $order = self::find($order_id);
        $data  = [
            'shipping_status' => $request->shipping_status
        ];
        return $order->update($data);

    }


    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderaddress()
    {
        return $this->hasOne(OrderAddress::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    final public function activity_logs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
        final public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    final public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @param int $user_id
     * @return LengthAwarePaginator
     */
    final public function getOrderByUser(int $user_id): LengthAwarePaginator
    {
        return self::query()->with('user')->orderByDesc('id')->where('user_id', $user_id)->paginate(10);
    }



    /**
     * @param string $order_id
     * @param bool $is_self
     * @return Model|null
     */
    final public function getOrderDetailsById(string $order_id, bool $is_self = false): Model|null
    {
        $query = self::query()->where('invoice_no', $order_id);
        if ($is_self) {
            $query->where('user_id', Auth::id());
        }
        $query->with([
            'order_items',
            'order_items.order_items_attributes',
            'shipping_address',
            'shipping_address.zone',
            'shipping_address.city',
            'shipping_address.division',
            'billing_address.zone',
            'billing_address.city',
            'billing_address.division',
            'transactions',
            'transactions.payment_method'
        ]);
        return $query->first();
    }



    public function shipping_address()
    {
        return $this->hasOne(OrderAddress::class)->whereIn('address_type', [Address::ADDRESS_TYPE_SHIPPING, Address::ADDRESS_TYPE_ALL]);
    }

    public function billing_address()
    {
        return $this->hasOne(OrderAddress::class)->whereIn('address_type', [Address::ADDRESS_TYPE_BILLING, Address::ADDRESS_TYPE_ALL]);
    }

    public function payment_methods()
    {
        return $this->belongsTo(PaymentMethod::class);
    }


    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable')->orderByDesc('id');
    }

}
