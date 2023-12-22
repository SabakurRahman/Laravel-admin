@extends('frontend.layouts.master')
@section('content')
    @include('global_partials.flash')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <div class="card dashboard-card text-center">
                                    <a href="" class="text-decoration-none">
                                        <div class="card-header bg-info text-white">
                                            <h5>All Orders</h5>
                                        </div>
                                        <h1 class="card-text p-3">

                                            {{$allOrders['allOrders']}}
                                        </h1>
                                    </a>
                                </div>
                            </div>


                            <div class="col-md-3 mb-2">
                                <div class="card dashboard-card text-center">
                                    <a href="" class="text-decoration-none">
                                        <div class="card-header bg-info text-white">
                                            <h5>Order pending</h5>
                                        </div>
                                        <h1 class="card-text p-3">{{$allOrders['orderStatus']}}</h1>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="card dashboard-card text-center">
                                    <a href="" class="text-decoration-none">
                                        <div class="card-header  bg-info text-white">
                                            <h5>Payment pending</h5>
                                        </div>
                                        <h1 class="card-text p-3">{{$allOrders['paymentPending']}}</h1>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="card dashboard-card text-center">
                                    <a href="" class="text-decoration-none">
                                        <div class="card-header  bg-info text-white">
                                            <h5>Order processing </h5>
                                        </div>
                                        <h1 class="card-text p-3">{{$allOrders['orderProcessing']}}</h1>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="card dashboard-card text-center">
                                    <a href="" class="text-decoration-none">
                                        <div class="card-header  bg-info text-white">
                                            <h5>Need expert call</h5>
                                        </div>
                                        <h1 class="card-text p-3">{{$allOrders['nextExpertCall']}}</h1>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="card dashboard-card text-center">
                                    <a href="" class="text-decoration-none">
                                        <div class="card-header  bg-info text-white">
                                            <h5>Office pickup</h5>
                                        </div>
                                        <h1 class="card-text p-3">{{$allOrders['allOrders']}}</h1>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="card dashboard-card text-center">
                                    <a href="" class="text-decoration-none">
                                        <div class="card-header  bg-info text-white">
                                            <h5>Order cancel</h5>
                                        </div>
                                        <h1 class="card-text p-3">{{$allOrders['orderPickup']}}</h1>
                                    </a>
                                </div>
                            </div>
                        </div>


                        @include('order.partials.search')

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Order Time</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Customer Role</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Product</th>
                                <th scope="col">Order Status</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Total Order</th>
                                <th scope="col">view</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $orderList as $list)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $list->created_at->format('D, M j, Y g:i A') }}</td>
                                    <td>{{$list->invoice_no}}</td>
                                    <td> @foreach($list->user->roles as $roleList)
                                            <button class="btn btn-sm btn-info">{{$roleList->name}}</button>
                                        @endforeach
                                    </td>
                                    <td><p><i class="ri-user-line"></i> {{$list->user->name}}</p>
                                        <p>
                                            <i class="ri-phone-line"></i> {{$list->user->phone}}
                                        </p>
                                        <i class="ri-map-pin-line"></i>
                                        {{
                                         $list->orderaddress?->cities?->name,
                                         $list->orderaddress?->postal_code
                                        }}

                                    </td>

                                    <td>
                                        @foreach($list?->order_items as $orderItemList )
                                            <ul>
                                                <li>{{ $orderItemList?->name}}</li>
                                            </ul>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{\App\Models\Order::ORDER_STATUS_LIST[$list->order_status] ?? null}}
                                    </td>
                                    <td>
                                        {{ \App\Models\Order::PAYMENT_STATUS_LIST[$list->payment_status]  ?? null}}
                                    </td>
                                    <td>{{$list->total_payable_amount}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('order.show',$list->id) }}">
                                                <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                            </a>
                                            <a href="{{ route('order.edit',$list->id) }}">

                                                <button class="mx-1 btn btn-sm btn-warning"><i
                                                        class="ri-edit-box-line"></i></button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
    {{ $orderList->links() }}
@endsection


