@extends('frontend.layouts.master')
@section('content')
{{--    @include('blog.partials.search')--}}
    <table class="table table-striped">
        <thead>
        <tr>
            <th>SL</th>
            <th>Customer Name</th>
            <th>Total Item</th>
            <th>Total Quantity</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cartList as $customer_name=>$cart)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $customer_name }}</td>
                <td>{{ $cart['total_items']}}</td>
                <td>{{ $cart['total_quantity']}}</td>

                <td>
                    <div class="d-flex">
                        <button data-bs-toggle="modal" data-bs-target="#cart_details_show" data-customer="{{$customer_name}}" data-cart="{{json_encode($cart['data'])}}" class="show-cart-details btn btn-sm btn-success">
                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                </td>

            </tr>
        @endforeach

        </tbody>
        @empty($cartList)
            <!-- Content to display when the $carts collection is empty -->
        @endempty
    </table>

    {{ $cartList->links() }}

<div class="modal fade" id="cart_details_show" tabindex="-1" aria-labelledby="cart_details_show_heading" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="cart_details_show_heading">Cart Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Updated On</th>
                    </tr>
                    </thead>
                    <tbody id="cart_details_table">

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')

    <script>
        const generateTable = (product, index) => {
            console.log(product)
            return ` <tr>
                            <th>${index+1}</th>
                            <th>${product?.product?.title}</th>
                            <th>${product?.quantity}</th>
                            <th>${moment(product.created_at).format('MMMM Do YYYY, h:mm:ss a')}</th>
                        </tr>`
        }

        $('.show-cart-details').on('click', function () {
            $('#cart_details_show_heading').text($(this).attr('data-customer') + ` Cart items`)
            let products = JSON.parse($(this).attr('data-cart'))
            let table = ``
            products.map((product, index)=>(
                table+=generateTable(product, index)
            ))
            $('#cart_details_table').html(table)
        })
    </script>


@endpush


