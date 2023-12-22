@extends('frontend.layouts.master')
@section('content')
    <style>
        :root {
            --theme-color: #219ab4;
        }

        ul,
        p,
        h1 h2,
        h3,
        h4,
        h5,
        h6,
        address {
            margin: 0;
            padding: 0;
        }

        .language-switch select {
            background: transparent;
            color: gray;
            border: 1px solid #405763;
        }

        .language-switch select:focus-visible {
            outline: none;
        }

        .btn-theme {
            color: #fff;
            background-color: #219ab4;
            border-color: #15768b;
        }

        .btn-theme:hover {
            background-color: #15768b;
            border-color: #116374;
            color: #fff;
        }


        .text-theme {
            color: var(--theme-color);
        }

        .preview_image {
            width: 50%;
            object-fit: cover;
        }

        table th {
            font-weight: bold;
        }

        table th,
        table tr {
            vertical-align: middle;
        }

        .alert {
            padding: 0.75rem 2.25rem;
        }

        .custom-input-group {
            margin-bottom: 15px;
        }

        .icon-image {
            width: 15px;
        }

        .mce-content-body ::before {
            left: unset !important;
        }

        /*remix icon override*/
        .ri-lg {
            vertical-align: -0.25em !important;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .info-icon {
            font-size: 1.3333em;
            line-height: .75em;
            vertical-align: -0.25em !important;
            cursor: pointer;
            color: var(--theme-color);
        }

        .tooltip-inner,
        .tooltip-arrow-inner {
            background: var(--theme-color);
        }

        .bs-tooltip-top .tooltip-arrow::before,
        .bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow::before {
            border-top-color: var(--theme-color);
        }

        hr {
            margin-top: .5rem;
            margin-bottom: .5rem;
            border: 0;
            border-top: 1px solid rgba(180, 229, 238, 0.726);
        }

        .product-thumb-in-table {
            width: 60px;
            border-radius: 50%;
            border: 3px solid rgba(0, 0, 0, .25);
            box-shadow: 0 3px 10px gray;
        }

        .single-line-text {
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 250px;
            overflow: hidden;
        }

        .test {
            display: block;
        }

        .ts-control :where(.item) {
            background: #d1d1d1 !important;
            border-radius: 3px !important;
        }

        #variation_display_area :where(.card-header) {
            background-color: #219ab457 !important;
        }

        #variation_display_area :where(.card-body) {
            background-color: #219ab41c !important;
        }

        #variation_display_area :where(.btn-secondary) {
            background-color: #1d8399 !important;
            border-color: #187b91 !important;
        }

        #variation_display_area :where(.form-check-inline) {
            margin-bottom: 9px !important;
        }

        #variation_display_area :where(label) {
            margin-bottom: 0 !important;
        }

        .var-image-overly {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #00000040;
            opacity: 0;
            transition: all .3s ease-in-out;
        }

        .var-image-overly-black {
            background: rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            opacity: 0;
        }

        .variation-image-display-area:hover .var-image-overly {
            opacity: 1;
            /*transition: all .3s ease-in-out;*/
        }

        .variation-image-display-area:hover .var-image-overly-black {
            opacity: 1;
            /*transition: all .3s ease-in-out;*/
        }

        del {
            position: relative;
            text-decoration: none;
        }

        del::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background: #ff0000;
            transform: rotate(-10deg);
        }

        .dashboard-card {
            box-shadow: 0 0 10px rgba(18, 38, 63, .3) !important;
            border-radius: 10px !important;
            transition: .3s all ease-in-out;
        }

        .dashboard-card:hover {
            transform: scale(1.03);
        }

        .dashboard-card .card-header {
            background-color: #219ab46b !important;
            border-radius: 10px 10px 0 0 !important;
        }

        .dashboard-card .card-header h4 {
            font-weight: bold;
        }

        #perPage {
            width: 72px;
            margin-top: 8px;
        }

        .d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between {
            margin-top: 8px;
        }



        .btn-group-sm>.btn,
        .btn-sm {
            padding: 0.4rem .8rem;
            font-size: 1rem;
            border-radius: 0.3rem;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <h4><strong>{{$order->invoice_no}}</strong></h4>
                            <table class="table table-sm table-bordered padding-less-table">
                                <tbody>
                                <tr>
                                    <th>Customer</th>
                                    <td>{{$order?->user?->name}}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{$order?->user?->email}}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{$order?->user?->phone}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-8">

                         @if($order->order_status != \App\Models\Order::ORDER_CANCEL )
                            <a  href = "{{ route('order.cancel', ['order_id' => $order->id]) }}" class="btn btn-sm btn-danger my-1" style="width: 200px;">Cancel
                                Order</a>
                            @endif
                            <div class="row mb-1">
                                <div id="changeOrderStatusContainer" class="col-md-4">
                                    <button id="changeOrderStatusBtn" class="btn btn-sm btn-info" style="width: 200px;">Change Order Status</button>

                                </div>
                                <div id="orderStatusContainer" class="col-md-4" style="display: none;">
                                    <form action="{{ route('order.status.change', ['order_id' => $order->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')                                        <div class="d-flex">
                                            <select name="order_status" class="form-select form-select-sm" id="order_status">
                                                <option value="">Select Status</option>
                                                @foreach(App\Models\Order::ORDER_STATUS_LIST as $statusKey => $statusName)
                                                    <option value="{{ $statusKey }}">
                                                        {{ $statusName }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div id="saveBtnContainer" class="col-md-3 ms-1" style="display: none;">
                                                <button class="btn btn-sm btn-info">Save</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>



                            </div>

                            <div class="row mb-1">
                                <div id="changeShippingStatusContainer" class="col-md-4">
                                    <button id="changeShippingStatusBtn" class="btn btn-sm btn-success" style="width: 200px;">Change Shipping
                                        Status</button>
                                </div>
                                <div id="shippingStatusContainer" class="col-md-4" style="display: none;">
                                    <form action="{{ route('shipping.status.change', ['order_id' => $order->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="d-flex">
                                            <select name="shipping_status" class="form-select form-select-sm">
                                                <option value="">Select Status</option>
                                                @foreach(App\Models\Order::SHIPPING_STATUS_LIST as $statusKey => $statusName)
                                                    <option value="{{ $statusKey }}">
                                                        {{ $statusName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div id="saveBtnContainer2" class="col-md-3 ms-1" style="display: none;">
                                                <button class="btn btn-sm btn-success">Save</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>



    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-target="#info" data-bs-toggle="tab" href="#info"
                   role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">General</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-target="#billing_info" data-bs-toggle="tab" href="#billing_info"
                   role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">Billing Info</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-target="#shipping_info" data-bs-toggle="tab"
                   href="#shipping_info" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">Shipping Info</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-target="#order_products" data-bs-toggle="tab"
                   href="#order_products" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">Order Items</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-target="#transactions" data-bs-toggle="tab" href="#transactions"
                   role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">Transactions</span>
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-target="#order_notes" data-bs-toggle="tab"
                   href="#order_notes" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">Order Notes</span>
                </a>
            </li>
        </ul>
        <div class="tab-content p-3">
            <div class="tab-pane active" id="info" role="tabpanel" tabindex="0">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Basic Info</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover table-striped table-bordered table-sm">
                                    <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>{{$order->id}}</th>
                                    </tr>
                                    <tr>
                                        <th>Order No</th>
                                        <th>{{$order->invoice_no}}</th>
                                    </tr>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>{{$order?->user?->name}}</th>
                                    </tr>
                                    <tr>
                                        <th>Total Items</th>
                                        <th>{{$order->total_quantity}}</th>
                                    </tr>
                                    <tr>
                                        <th>Total Amount</th>
                                        <th>৳ {{$order->total_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th>Shipping Charge</th>
                                        <th>৳ {{$order->shipping_charge}}</th>
                                    </tr>
                                    <tr>
                                        <th>Total Discount Amount</th>
                                        <th>৳ {{$order->total_discount_amount}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Total Payable Amount</th>
                                        <th>৳ {{$order->total_payable_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th>Payment Status</th>
                                        <th>      {{ \App\Models\Order::PAYMENT_STATUS_LIST[$order->payment_status] ?? 'Undefined Payment Status' }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Shipping Status</th>
                                        <th>{{\App\Models\Order::SHIPPING_STATUS_LIST[$order->shipping_status] ?? 'Undefined Shipping Status' }}</th>
                                    </tr>
                                    <tr>
                                        <th>Order Status</th>
                                        <th>
                                            {{\App\Models\Order::ORDER_STATUS_LIST[$order->order_status] ?? 'Undefined Status' }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Comment</th>
                                        <th>{{$order->comment}}</th>
                                    </tr>
                                    <tr>
                                        <th>Order Placed at</th>
                                        <th>{{ date('F j, Y, g:i A', strtotime($order->order_date)) }}</th>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="billing_info" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Billing address</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover table-striped table-bordered table-sm">
                                    <tbody>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>{{$order?->user->name}}</th>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <th>{{$order?->user->email}}</th>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <th>{{$order?->user->phone}}</th>
                                    </tr>
                                    <tr>
                                        <th>Street Address</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Zone</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Division</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Zip</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Landmark</th>
                                        <th></th>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="shipping_info" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Shipping address</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover table-striped table-bordered table-sm">
                                    <tbody>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>{{$order?->user->name}}</th>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <th>{{$order?->user->email}}</th>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <th>{{$order?->user->phone}}</th>
                                    </tr>
                                    <tr>
                                        <th>Street Address</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Zone</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Division</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Zip</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Landmark</th>
                                        <th></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="order_products" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Order Items</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Discount</th>
                                        <th>Sub Total</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order?->order_items as $orderItemList )
                                    <tr>

                                       <th>{{ $loop->iteration }}</th>
                                        <th class="w-35">
                                            <div class="d-flex align-items-center"
                                                 data-bs-toggle="tooltip"
                                                 @php
                                                     $firstPhoto = $orderItemList->product->ProductPhotos->first();
                                                 @endphp

                                            <title>{{ isset($firstPhoto->title) ? $firstPhoto->title : 'Default Title' }}</title>

                                            <div class="flex-shrink-0">
                                                    <img class="product-thumb-in-table me-2"
                                                         src="{{ isset($firstPhoto->photo) ? asset(App\Models\ProductPhoto::PHOTO_UPLOAD_PATH . $firstPhoto->photo) : '' }}"
                                                         alt="...">
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <p class="two-line">{{ $orderItemList?->name}}</p>

                                                </div>
                                        </th>




                                        <th>{{ $orderItemList?->sku}}</th>
                                        <th>৳ {{ $orderItemList?->quantity}}</th>
                                        <th>৳ {{ $orderItemList?->unit_price}}</th>
                                        <th>৳ {{ $orderItemList?->discount_amount}}</th>
                                        <th>৳ {{ $orderItemList?->total_amount}}</th>
                                        <th>Action</th>

                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="transactions" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Transactions</h4>
                            </div>
                            <div class="card-body">

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                    <i class="ri-add-line"></i>Add Transaction
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Transaction
                                                    Form
                                                </h5>
                                                <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="https://deshify-admin.microhost.one/admin/add-transaction/102"
                                                      method="POST">
                                                    <input type="hidden" name="_token" value="0UTO6pbglEuJRltxAjJDACsb2N65JCDOHAqaTph6" autocomplete="off">                                                                    <div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="validationCustom03"
                                                                           class="form-label">Payment
                                                                        Methods</label>
                                                                    <select class="form-select"
                                                                            name="payment_method_id" required>
                                                                        <option selected disabled
                                                                                value="">Choose</option>
                                                                        <option
                                                                            value="4">
                                                                            Cash on Delivery (COD)
                                                                        </option>
                                                                        <option
                                                                            value="3">
                                                                            Rocket
                                                                        </option>
                                                                        <option
                                                                            value="2">
                                                                            Nagad
                                                                        </option>
                                                                        <option
                                                                            value="1">
                                                                            Bkash
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                           for="basicpill-trx_idkname-input">
                                                                        Transaction Id
                                                                    </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="basicpill-trx_idkname-input"
                                                                           name="trx_id"
                                                                           value=""
                                                                           placeholder="Enter Transaction Id"
                                                                           required>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="validationCustom03"
                                                                           class="form-label">Transaction Type
                                                                    </label>
                                                                    <select class="form-select"
                                                                            name="transaction_type" required>
                                                                        <option selected disabled
                                                                                value="">Choose</option>
                                                                        <option
                                                                            value="1">
                                                                            Credit
                                                                        </option>
                                                                        <option
                                                                            value="2">
                                                                            Debit
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                           for="basicpill-amountkname-input">
                                                                        Amount
                                                                    </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="basicpill-amountkname-input"
                                                                           name="amount"
                                                                           value=""
                                                                           placeholder="Enter Transaction Id"
                                                                           required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>


                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        <button type="submit"
                                                                class="btn btn-primary">Save</button>
                                                    </div>

                                                </form>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="datatable"
                                           class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Customer Name</th>
                                            <th>User Name</th>
                                            <th>Order Id</th>
                                            <th>Amount</th>
                                            <th>Transactions Id</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Date time</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="order_notes" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #cef0f0">
                                <p>Add Order Note </p>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Order Notes</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Created On</th>
                                            <th>Note</th>
                                            <th>Display To Customer</th>
                                            <th>Created By</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($order?->activity_logs)
                                        <tr>

                                                @foreach($order?->activity_logs as $activityLog)
                                                <th>{{ $loop->iteration }}</th>
                                                <th>{{ date('d/m/Y h:i:s A', strtotime($activityLog->created_at)) }}</th>
                                                <th>{{ $activityLog->note}}</th>
                                                <td> <span class="badge bg-danger"> <i
                                                            class="fas fa-times "></i> No</span></td>
                                                <th>{{$activityLog?->user->name}}</th>

                                        </tr>
                                        @endforeach
                                            @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Order Note
                                                Found</td>
                                            </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-body">
                                    <div class="customer-service-note">
                                        @foreach($order?->activity_logs as $activityLog)
                                            <p>({{ date('d/m/Y h:i:s A', strtotime($activityLog->created_at)) }})
                                                - {{$activityLog?->user->name}}- (
                                                {{ url('/') }}) - Note:-
                                                {{ $activityLog->note}}: </p>
                                        @endforeach


                                    </div>
                                    <form action="{{ route('add.order.note', ['order_id' => $order->id]) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-check-label" for="note">Note </label>
                                            <input type="text" class="form-control mt-2"
                                                   id="note" name="note">
                                        </div>




                                        <div
                                            class="form-check form-check-custom form-check-primary form-check-inline font-size-16 mb-3">
                                            <input class="form-check-input" type="hidden"
                                                   name="display_to_customer" value="0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="include-top-menu" name="display_to_customer"
                                                   value="1">

                                            <label class="form-check-label" for="include-top-menu">
                                                Display to customer</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-sm mt-3">Add Order
                                                Note</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>



                    <script>
                        if ("Order Cancelled Successfully") {
                            Swal.fire({
                                position: 'top-end',
                                icon: "success",
                                title: "Order Cancelled Successfully",
                                showConfirmButton: false,
                                toast: true,
                                timer: 1500
                            })
                        }

                        $('#submitButton').on('click', function () {
                            $('#myForm').submit()
                        })



                        new TomSelect("#input-tags", {
                            persist: false,
                            createOnBlur: true,
                            create: true
                        });

                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl)
                        })
                    </script>






                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var changeOrderStatusContainer = document.getElementById('changeOrderStatusContainer');
                            var changeOrderStatusBtn = document.getElementById('changeOrderStatusBtn');
                            var orderStatusContainer = document.getElementById('orderStatusContainer');
                            var saveBtnContainer = document.getElementById('saveBtnContainer');

                            changeOrderStatusBtn.addEventListener('click', function() {
                                orderStatusContainer.style.display = 'block';
                                saveBtnContainer.style.display = 'block';
                                changeOrderStatusContainer.style.display = 'none';
                            });
                        });
                    </script>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var changeShippingStatusContainer = document.getElementById('changeShippingStatusContainer');
                            var changeShippingStatusBtn = document.getElementById('changeShippingStatusBtn');
                            var shippingStatusContainer = document.getElementById('shippingStatusContainer');
                            var saveBtnContainer2 = document.getElementById('saveBtnContainer2');

                            changeShippingStatusBtn.addEventListener('click', function() {
                                shippingStatusContainer.style.display = 'block';
                                saveBtnContainer2.style.display = 'block';
                                changeShippingStatusContainer.style.display = 'none';
                            });
                        });



                    </script>


@endsection


