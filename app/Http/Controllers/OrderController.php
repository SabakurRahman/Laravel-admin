<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderDetailsResource;
use App\Http\Resources\OrderListResource;
use App\Manager\CommonResponse;
use App\Manager\Formatter;
use App\Manager\ProductVariationManager;
use App\Models\ActivityLog;
use App\Models\Order;
use Throwable;
use App\Models\Cart;
use App\Models\City;
use App\Models\User;
use App\Models\Zone;
use App\Models\Courier;
use App\Models\Product;
use App\Models\Division;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Validation\ValidationException;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_content = [
            'page_title'      => __('Order List'),
            'module_name'     => __('Order'),
            'sub_module_name' => __('List'),
            'module_route'    => route('order.create'),
            'button_type'     => 'create' //create
        ];
        $columns      = Schema::getColumnListing('orders');
        $filters      = $request->all();
        $orderList    = (new Order())->allOrderList($request);
        $allOrders    = (new Order)->getOrderCounts();

        return view('order.index', compact('orderList', 'page_content',
            'filters', 'columns', 'allOrders'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $page_content = [
            'page_title'      => __('Order Create'),
            'module_name'     => __('Order'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('order.index'),
            'button_type'     => 'list' //create
        ];

        $products        = (new Product())->getProductsNameId();
        $couriers        = (new Courier())->getCourierName();
        $payment_methods = (new PaymentMethod())->getPaymentMethodName();
//        $payments        = (new PaymentList())->getAllPaymentListsForDropDown();
        $divisions = (new Division())->getDivisionAssoc();
        $city      = (new City())->getAllCity([], ['id', 'name', 'division_id']);
        $zone      = (new Zone())->getAllZonesForDropdown();
        $user      = null;
        $address   = null;
        if ($request->has('user_id')) {
            $user    = User::query()
                ->with('addresses')
                ->findOrFail($request->input('user_id'));
            $address = $user->addresses->where('is_default', 1)->first();
        }
        return view('order.create',
            compact(
                'page_content',
                'products',
                'couriers',
                'payment_methods',
                'divisions',
                'city',
                'zone',
//                'payments',
                'user',
                'address'
            ));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //  dd($request->all());
        //  dd($request->input('selected_products'));
        $selectedProducts = json_decode($request->input('selected_products'));
        if (!empty($selectedProducts)) {

            foreach ($selectedProducts as $products) {


                if (!empty($products->product)) {
                    if ($products->product->product_type != Product::PRODUCT_TYPE_GROUPED) {
                        $product = $products->product;

                        $insufficientStock = false;

                        $inventory = $product->inventories;

                        if ($product->quantity > $inventory->stock) {
                            $insufficientStock = true;

                        }


                        if ($insufficientStock) {
                            $validation_message = $product->title . ' has insufficient stock';
                        }

                    }

                }
            }


        } else {
            $validation_message = 'Selected product is empty';
        }


        $order_data = [
            'invoice_no'            => Formatter::generateInvoiceId(),
            'user_id'               => Auth::id(),
            'total_quantity'        => $request->quantity,
            'total_amount'          => $request->amount,
            'total_discount_amount' => $request->discount,
            'total_payable_amount'  => $request->sub_total,
            'payment_status'        => Order::PAYMENT_STATUS_UNPAID,
            'shipping_status'       => Order::SHIPPING_STATUS_PENDING,
            'order_status'          => $request->order_status,
            'comment'               => $request->comment,
            'user_ip'               => $request->ip(),
            'courier_id'            => $request->courier_id,
            'order_date'            => $request->order_time,
            'shipping_charge'       => $request->delivery_charge,
            'order_from'            => Order::ORDER_FROM_CUSTOMER
        ];


        $order = Order::query()->create($order_data);


        (new OrderAddress())->storeOrderAddress($request, $order);
        if (!empty($selectedProducts)) {
            (new OrderItem())->storeOrderItemsByAdmin($selectedProducts, $order);
        }
        (new Transaction())->store_order_transaction($request, $order);
        return redirect()->route('order.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $page_content = [
            'page_title'      => __('Order Details'),
            'module_name'     => __('Order'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('order.index'),
            'button_type'     => 'list' //create
        ];
        $order->load('order_items.product.ProductPhotos', 'orderaddress', 'orderaddress.cities', 'activity_logs.user');
        return view('order.show', compact('page_content', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Order $order)
    {
        $page_content = [
            'page_title'      => __('Order Edit'),
            'module_name'     => __('Order'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('order.index'),
            'button_type'     => 'list' //create
        ];
        $order->load('order_items');

        $products        = (new Product())->getProductsNameId();
        $couriers        = (new Courier())->getCourierName();
        $payment_methods = (new PaymentMethod())->getPaymentMethodName();
        $divisions       = (new Division())->getDivisionAssoc();
        $city            = (new City())->getAllCity([], ['id', 'name', 'division_id']);
        $zone            = (new Zone())->getAllZonesForDropdown();
        $user            = null;
        $address         = null;
        if ($request->has('user_id')) {
            $user    = User::query()
                ->with('addresses')
                ->findOrFail($request->input('user_id'));
            $address = $user->addresses->where('is_default', 1)->first();
        }
        return view('order.edit',
            compact(
                'page_content',
                'products',
                'couriers',
                'payment_methods',
                'divisions',
                'city',
                'zone',
                'user',
                'address', 'order'
            ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $selectedProducts = json_decode($request->input('selected_products'));
        if (!empty($selectedProducts)) {

            foreach ($selectedProducts as $products) {


                if (!empty($products->product)) {
                    if ($products->product->product_type != Product::PRODUCT_TYPE_GROUPED) {
                        $product = $products->product;

                        $insufficientStock = false;

                        $inventory = $product->inventories;

                        if ($product->quantity > $inventory->stock) {
                            $insufficientStock = true;

                        }


                        if ($insufficientStock) {
                            $validation_message = $product->title . ' has insufficient stock';
                        }

                    }

                }
            }


        } else {
            $validation_message = 'Selected product is empty';
        }


        $order_data = [
            'user_id'               => Auth::id(),
            'total_quantity'        => $request->quantity ?? $order->total_quantity,
            'total_amount'          => $request->amount ?? $order->total_amount,
            'total_discount_amount' => $request->discount ?? $order->total_discount_amount,
            'total_payable_amount'  => $request->sub_total ?? $order->total_payable_amount,
            'payment_status'        => Order::PAYMENT_STATUS_UNPAID ?? $order->payment_status,
            'shipping_status'       => Order::SHIPPING_STATUS_PENDING ?? $order->shipping_status,
            'order_status'          => $request->order_status ?? $order->order_status,
            'comment'               => $request->comment ?? $order->comment,
            'user_ip'               => $request->ip(),
            'courier_id'            => $request->courier_id ?? $order->courier_id,
            'order_date'            => $request->order_time ?? $order->order_date,
            'shipping_charge'       => $request->delivery_charge ?? $order->shipping_charge,
            'order_from'            => Order::ORDER_FROM_CUSTOMER ?? $order->order_from
        ];


        $order->update($order_data);


        foreach ($selectedProducts as $selectedProduct) {

            $existingOrderItem = $order->order_items()->where('product_id', $selectedProduct->id)->first();

            if (!$existingOrderItem) {
                (new OrderItem())->updateOrderItemsByAdmin($selectedProduct, $order);
            }

        }

        (new OrderAddress())->storeOrderAddress($request, $order);
        (new Transaction())->store_order_transaction($request, $order);
        return redirect()->route('order.index');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }


    public function storePlaceOrder(Request $request)
    {
        $commonResponse = new CommonResponse();
        try {
            DB::beginTransaction();
            $carts = (new Cart())->getUserCarts(Auth::id());
            // dd($carts);
            Log::info('CART_DATA_BEFORE_ORDER_PLACED', ['carts' => $carts]);
            $order_items_data      = [];
            $total_quantity        = 0;
            $total_amount          = 0;
            $total_discount_amount = 0;
            $total_payable_amount  = 0;
            $validation_message    = '';
            if (count($carts) < 1) {
                $validation_message = 'Your Cart is Empty';
            }
            foreach ($carts as $cart) {

                $total_quantity        += $cart->quantity;
                $prices                = ProductVariationManager::handleCartVariationData($cart);
                $total_amount          += $prices['price'] * $cart->quantity;
                $total_discount_amount += $prices['discount_amount'] * $cart->quantity;
                $total_payable_amount  += $prices['payable_price'] * $cart->quantity;
                // dd(!empty($cart->product));
                if (!empty($cart->product)) {
                    if ($cart->product->product_type != Product::PRODUCT_TYPE_GROUPED) {
                        $product = $cart->product;

                        $insufficientStock = false;

                        $inventory = $product->inventories;

                        if ($cart->quantity > $inventory->stock) {
                            $insufficientStock = true;

                        }


                        if ($insufficientStock) {
                            $validation_message = $product->title . ' has insufficient stock';
                        }

                    }

                }
            }
            if (!empty($validation_message)) {
                throw ValidationException::withMessages(['address_id' => $validation_message]);
            }
            $order_data = [
                'invoice_no'            => Formatter::generateInvoiceId(),
                'user_id'               => Auth::id(),
                'total_quantity'        => $total_quantity,
                'total_amount'          => $total_amount,
                'total_discount_amount' => $total_discount_amount,
                'total_payable_amount'  => $total_payable_amount,
                'payment_status'        => Order::PAYMENT_STATUS_UNPAID,
                'shipping_status'       => Order::SHIPPING_STATUS_PENDING,
                'order_status'          => Order::ORDER_STATUS_PENDING,
                'comment'               => '',
                'user_ip'               => $request->ip(),
                'shipping_charge'       => 0.00,
                'shipping_address_id'   => $request->input('shipping_address_id'),
                'billing_address_id'    => $request->input('billing_address_id'),
                'order_from'            => Order::ORDER_FROM_CUSTOMER,
            ];
            //dd($order_data);

            $order = Order::query()->create($order_data);

            (new OrderAddress())->storeOrderAddress($request, $order);
            (new OrderItem())->storeOrderItems($carts, $order);
            (new Transaction())->store_order_transaction($request, $order);
            DB::commit();
            $commonResponse->status_message = __('Order placed successfully');
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ORDER_PLACED_FAILED', ['error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();


    }

    public function orderCancel($order_id)
    {
        (new Order())->cancelOrder($order_id);
        return redirect()->back();
    }


    public function orderStatusChange(Request $request, $order_id)
    {

        (new Order())->changeOrderStatus($request, $order_id);

        return redirect()->back();


    }


    public function shippingStatusChange(Request $request, $order_id)
    {
        (new Order())->changeShippingStatus($request, $order_id);

        return redirect()->back();

    }

    public function addOrderNote(Request $request, $order_id)
    {
        $order    = Order::find($order_id);
        $original = $order->getOriginal();
        $changed  = $order->getChanges();
        (new ActivityLog())->storeActivityLog($request, $original, $changed, $order);

        return redirect()->back();


    }


    public function order_place(Request $request)
    {
        $commonResponse = new CommonResponse();
        try {
            DB::beginTransaction();
            $carts = (new Cart())->getUserCarts(Auth::id());
            Log::info('CART_DATA_BEFORE_ORDER_PLACED', ['carts' => $carts]);
            $order_items_data      = [];
            $total_quantity        = 0;
            $total_amount          = 0;
            $total_discount_amount = 0;
            $total_payable_amount  = 0;
            $validation_message    = '';
            if (count($carts) < 1) {
                $validation_message = 'Your Cart is Empty';
            }
            foreach ($carts as $cart) {
                $total_quantity        += $cart->quantity;
                $prices                = ProductVariationManager::handleCartVariationData($cart);
                $total_amount          += $prices['price'] * $cart->quantity;
                $total_discount_amount += $prices['discount_amount'] * $cart->quantity;
                $total_payable_amount  += $prices['payable_price'] * $cart->quantity;
                if (!empty($cart->product)) {
                    if ($cart->product->product_type != Product::PRODUCT_TYPE_GROUPED) {
                        //simple
                        if ($cart->quantity > $cart->product->inventories->stock || $cart->product->is_out_of_stock == 1) {
                            $validation_message = $cart->product->title . ' no enough stock';
                        }
                    } else if ($cart->quantity > $cart->productVariations->productInventory->stock || $cart->product->is_out_of_stock == 1) {
                        $validation_message = $cart->product->title . ' no enough stock';
                    }
                }
            }
            if (!empty($validation_message)) {
                throw ValidationException::withMessages(['address_id' => $validation_message]);
            }

//            $discount = Discount::query()
//                ->where('coupon_code', $request->input('coupon_code'))
//                ->whereDate('start_date', '<=', Carbon::now()->endOfDay())
//                ->whereDate('end_date', '>=', Carbon::now()->endOfDay())
//                ->first();
//
//            if ($total_discount_amount < 1 && $request->input('coupon_code')) {
//                $coupon_discount = 0;
//                if ($discount) {
//                    if ($discount->discount_type == Discount::DISCOUNT_TYPE_PERCENT) {
//                        $coupon_discount = ($total_payable_amount * $discount->discount) / 100;
//                    } elseif ($discount->discount_type == Discount::DISCOUNT_TYPE_FIXED) {
//                        $coupon_discount = $discount->discount;
//                    }
//                }
//                $total_discount_amount = $coupon_discount;
//                $total_payable_amount  -= $coupon_discount;
//            }

            $order_data = [
                'invoice_no'            => \App\Manager\Utility\Formatter::generateInvoiceId(),
                'user_id'               => Auth::id(),
                'total_quantity'        => $total_quantity,
                'total_amount'          => $total_amount,
                'total_discount_amount' => $total_discount_amount,
                'total_payable_amount'  => $total_payable_amount,
                'payment_status'        => Order::PAYMENT_STATUS_UNPAID,
                'shipping_status'       => Order::SHIPPING_STATUS_PENDING,
                'order_status'          => Order::ORDER_STATUS_PENDING,
                'comment'               => '',
                'user_ip'               => $request->ip(),
                'shipping_charge'       => 0.00,
//                'shipping_address_id'   => $request->input('shipping_address_id'),
//                'billing_address_id'    => $request->input('billing_address_id'),
                'order_from'            => Order::ORDER_FROM_CUSTOMER,
                'location'              => $request->input('location'),
                'discount_id'           => $discount->id ?? 0,
                'created_by'            => Auth::id(),
            ];
            $order      = Order::query()->create($order_data);
            (new OrderAddress())->storeApiOrderAddress($request, $order);
            (new OrderItem())->storeOrderItems($carts, $order);
//            (new Transaction())->store_order_transaction($request, $order);
            DB::commit();
            $commonResponse->status_message = __('Order placed successfully');
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ORDER_PLACED_FAILED', ['error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

    final public function invoice(Request $request, Order $order)
    {
        $order->load(
            [
                'orderItems',
                'orderaddress',
                'users',
                'customer',
                'transaction',
                'activity_logs'
            ]
        );
        // $orders = Order::query()->orderByDesc('id')->with(['transaction', 'transaction.payment_method'])->whereIn('id', $order_ids)->get();
        // // $orders = Order::query()->orderByDesc('id')->with(['transaction', 'transaction.payment_method'])->whereIn('id', $order_ids)->get();
        // $html   = '';
        // foreach ($orders as $key=>$order) {
        //     $view = view('modules.pdf.invoice')->with(compact('order', 'key'));
        //     $html .= $view->render();
        // }
        // return $html;
        //return Pdf::loadHTML($html)->setPaper('a4', 'portrait')->stream('invoice.pdf');
        return view('invoice.invoice', compact('order'));


    }


    public function my_orders()
    {
        $commonResponse = new CommonResponse();
        try {
            $commonResponse->data           = OrderListResource::collection((new Order())->getOrderByUser(Auth::id()))->response()->getData();
            $commonResponse->status_message = 'My order data faced successfully';
        } catch (Throwable $throwable) {
            Log::info('MY_ORDER_DATA_FETCHED-FAILED', ['error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }


    public function order_details(string $invoice_no)
    {
        $commonResponse = new CommonResponse();
        try {
            $order = (new Order())->getOrderDetailsById($invoice_no, true);
            if ($order) {
                $order                          = new OrderDetailsResource($order);
                $commonResponse->status_message = 'My order data faced successfully';
            } else {
                $order                          = [];
                $commonResponse->status_message = 'No data found';
            }
            $commonResponse->data = $order;
        } catch (Throwable $throwable) {
            Log::info('MY_ORDER_DATA_FETCHED-FAILED', ['error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

}
