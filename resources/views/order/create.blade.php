@extends('frontend.layouts.master')
@section('content')
    <div class="row">
        <div class="mb-1">
            <a href="{{ route('order.index') }}" class="btn btn-sm btn-theme mb-3"><i
                    class="ri-arrow-left-line"></i> Back </a>

        </div>
    </div>
    <form action="{{route('order.store')}}" method="POST" id="quick_order_form">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card quick-order-card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center mb-2">

                        </div>

                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Order Status </label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="order_status" id="order_status">

                                    <option selected disabled value="">Select Order Type </option>
                                    @foreach (App\Models\Order::ORDER_STATUS_LIST as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach

                                </select>
                                @error('order_status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card quick-order-card mb-4">
                    <div class="card-header">
                        <p>Customer Details</p>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Customer Name</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class=" form-control" id="basicpill-firstname-input"
                                       name="customer_name" value="{{ old('customer_name') ?? $user?->name ?? null }}"
                                       placeholder="Enter Customer Name">
                                @error('customer_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Phone Number</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class=" form-control" id="basicpill-firstname-input"
                                       name="phone_number" value="{{ old('phone_number') ?? $user?->phone ?? null }}"
                                       placeholder="Enter Phone Number">
                                @error('phone_number')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="example-date-input">Address</label>
                            </div>
                            <div class="col-md-8">
                            <textarea id="address" name="address"
                                      class="form-control">
{{--                                {{ old('address') }}--}}
                                @if($address?->street_address)
                                    {{trim($address?->street_address)}}
                                @endif

                            </textarea>
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card quick-order-card mb-4">
                    <div class="card-header">
                        <p>Shipping And Courier Information</p>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="location">Shipping Method </label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select select2" id="location" name="location">
                                    <option selected disabled value="">Select Shipping Method </option>
                                    @foreach (App\Models\Order::SHIPPING_LOCATION_LIST as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('location')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="courier_id">Courier </label>
                            </div>
                            <div class="col-md-8">
                                <div class="d-none" id="courier_data" data-courier="{{json_encode($couriers)}}"></div>
                                <select class="form-select select2" name="courier_id" id="courier_id">
                                    <option selected disabled value="">Select Courier</option>
                                    @foreach ($couriers as $courier)
                                        <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                                    @endforeach
                                </select>
                                @error('courier_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Division </label>
                            </div>
                            <div class="col-md-8" data-division="{{$address?->division_id}}">
                                <select class="form-select select2" name="division_id" id="division_select">
                                    <option selected disabled value="">Select Division</option>
                                                                        @foreach ($divisions as $key=>$value)
                                                                            <option
                                                                                {{$address?->division_id == $key ? 'selected' : null }} value="{{$key }}">{{ $value }}</option>
                                                                        @endforeach
                                </select>
                                @error('bank_account_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">City</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select select2" name="city_id" id="city_select" disabled>
                                    <option selected disabled value="">Select City</option>
                                </select>
                                @error('city_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Zone </label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select select2" name="zone_id" id="zone_select" disabled>
                                    <option selected disabled value="">Select Zone</option>
                                </select>
                                @error('zone_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card quick-order-card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center mb-2">


                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Order Date </label>
                            </div>
                            <div class="col-md-8">
                                <input id="order_time" value="{{\Carbon\Carbon::now()}}" name="order_time"
                                       type="datetime-local" class=" form-control">
                                @error('order_time')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card quick-order-card">
                    <div class="card-header">
                        <p>Product Info</p>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Product</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select select2" name="product_id" id="product_id">
                                    <option selected disabled value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Quantity</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class=" form-control" id="quantity"
                                       name="quantity" value="{{ old('quantity') }}"
                                       placeholder="Enter Quantity">
                                @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Unit Price</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class=" form-control" id="unit_price"
                                       name="unit_price" value="{{ old('unit_price') }}"
                                       placeholder="Enter Unit Price">
                                @error('unit_price')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Amount</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class=" form-control" id="amount"
                                       name="amount" value="{{ old('amount') }}"
                                       placeholder="Enter Amount">
                                @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div id="variation_attribute_area"></div>
                        {{--                        <div class="row align-items-center mb-2">--}}
                        {{--                            <div class="col-md-4">--}}
                        {{--                                <label class="form-label" for="basicpill-firstname-input">Size</label>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-8">--}}
                        {{--                                <select class="form-select select2" name="size">--}}
                        {{--                                    <option selected disabled value="">Select Size</option>--}}
                        {{--                                    @foreach (App\Models\QuickOrder::QUICK_ORDER_SIZE_LIST as $key => $value)--}}
                        {{--                                        <option value="{{ $key }}">{{ $value }}</option>--}}
                        {{--                                    @endforeach--}}
                        {{--                                </select>--}}
                        {{--                                @error('size')--}}
                        {{--                                <span class="text-danger">{{ $message }}</span>--}}
                        {{--                                @enderror--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="row align-items-center mb-2">--}}
                        {{--                            <div class="col-md-4">--}}
                        {{--                                <label class="form-label" for="basicpill-firstname-input">Color</label>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-8">--}}
                        {{--                                <select class="form-select select2" name="color">--}}
                        {{--                                    <option selected disabled value="">Select Color</option>--}}
                        {{--                                    @foreach (App\Models\QuickOrder::QUICK_ORDER_COLOR_LIST as $key => $value)--}}
                        {{--                                        <option value="{{ $key }}">{{ $value }}</option>--}}
                        {{--                                    @endforeach--}}
                        {{--                                </select>--}}
                        {{--                                @error('color')--}}
                        {{--                                <span class="text-danger">{{ $message }}</span>--}}
                        {{--                                @enderror--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <button type="button" id="add_product" class="btn btn-sm btn-success">Add Product</button>
                                @error('selected_products')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center my-3">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Amount</th>
                                    <th style="width: 150px">Attributes</th>
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                <tbody id="product_list">

                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

                <div class="card mt-3 mb-4">
                    <div class="card-header">
                        <p>Add payment details</p>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="payment_method_id"> Payment Type</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select select2" id="payment_method_id" name="payment_method_id">
                                    <option selected disabled value="">Select Payment Method</option>
                                    @foreach ($payment_methods as $payment_method)
                                        <option
                                            value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
{{--                        <div class="row align-items-center mb-2">--}}
{{--                            <div class="col-md-4">--}}
{{--                                <label class="form-label" for="payment_account"> Payment </label>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-8">--}}
{{--                                <select class="form-select select2" id="payment_account" name="payment_account">--}}
{{--                                    <option selected disabled value="">Select Account Type</option>--}}
{{--                                    @foreach ($payment_methods as $payment_method)--}}
{{--                                        <option--}}
{{--                                            value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('payment_account')--}}
{{--                                <span class="text-danger">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="sender_number">Sender Number</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class=" form-control" id="sender_number"
                                       name="sender_account_no" value="{{ old('sender_account_no') }}"
                                       placeholder="Enter Sender Number">
                                @error('sender_number')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="trx_id">Trx ID</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class=" form-control" id="trx_id"
                                       name="trx_id"
                                       placeholder="Enter Transaction ID">
                                @error('trx_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="paid_amount">Amount</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class=" form-control" id="paid_amount"
                                       name="paid_amount"
                                       placeholder="Enter amount">
                                @error('trx_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <p>Payment Overview </p>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="payment">Advance</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class=" form-control" id="payment"
                                       name="payment"
                                       placeholder="Enter Advance Amount">
                                @error('payment')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="sub_total">Sub Total</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class="form-control" id="sub_total"
                                       name="sub_total"
                                       placeholder="Enter Sub Total" readonly>
                                @error('sub_total')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="delivery_charge">Delivery</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class=" form-control" id="delivery_charge"
                                       name="delivery_charge"
                                       placeholder="Enter Delivery Charge">
                                @error('delivery_charge')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="discount">Discount</label>
                            </div>
                            <div class="col-md-8">

                                <input type="number"   class="form-control" id="discount"
                                       name="discount"
                                       placeholder="Enter Discount">
                                @error('discount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="payment">Paid</label>
                            </div>
                            <div class="col-md-8">
                                <p id="paid_amount"
                                   class="form-control text-success">0</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="total">Condition</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class=" form-control" id="total"
                                       name="total"
                                       placeholder="Enter condition amount">
                                @error('total')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-12 mb-2">
                <div class="card quick-order-card">
                    <div class="card-header">
                        <p>Order Note</p>
                    </div>
                    <div class="card-body">
                        <textarea id="comment" name="comment"
                                  class=" form-control">{{ old('comment') }}</textarea>
                        @error('comment')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <input type="hidden" id="selected_products" name="selected_products">
            <div class="col-md-12 text-center">
                 <button id="save_order" type="submit" class="btn btn-success">Save Order</button>

            </div>
        </div>
    </form>

    <div class="d-none" id="city_data_container" data-city="{{json_encode($city)}}"></div>
    <div class="d-none" id="zone_data_container" data-zone="{{json_encode($zone)}}"></div>
    <div class="d-none" id="product_data_container" data-product="{{json_encode($products)}}"></div>
    <div class="d-none" id="payments_data_container" data-payment="{{json_encode(['data'])}}"></div>
    <div class="d-none" id="data_customer_address" data-address="{{json_encode($address)}}"></div>
@endsection
@include('order.order_js')




