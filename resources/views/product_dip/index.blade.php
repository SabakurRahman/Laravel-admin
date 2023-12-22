@extends('frontend.layouts.master')
@section('title', 'Product List')
@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- @include('modules.product.partials.search') --}}
                    <a href="{{ route('product.create') }}">
                        <button class="btn btn-sm btn-theme mb-3"><i class="ri-add-line mt-3"></i> Add Product</button>
                    </a>
                    {{-- <a href="{{ route('product.export') }}">
                        <button class="btn btn-sm btn-theme mb-3"><i class="ri-file-excel-2-line"></i> Export CSV
                        </button>
                    </a>
                    <button class="btn btn-sm btn-theme mb-3" data-bs-toggle="modal" data-bs-target="#csv_upload"><i
                            class="ri-file-excel-2-fill"></i> Import Export CSV
                    </button> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Published</th>
                                <th>Created By</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <div data-bs-toggle="tooltip" title="{{$product->name}}"
                                             class="d-flex align-items-center">
                                            @if(isset($product->primaryPhoto->photo) && file_exists(public_path(\App\Models\ProductPhoto::PRODUCT_PHOTO_UPLOAD_PATH_THUMB.$product?->primaryPhoto?->photo)))
                                                <img
                                                        src="{{asset(\App\Models\ProductPhoto::PRODUCT_PHOTO_UPLOAD_PATH_THUMB.$product?->primaryPhoto?->photo)}}"
                                                        alt="{{$product?->primaryPhoto?->alt_text}}"
                                                        title="{{$product?->primaryPhoto?->title}}"
                                                        class="product-thumb-in-table me-2"
                                                />
                                            @endif
                                            <p class="single-line-text cursor-pointer">{{$product->name}}</p>
                                        </div>
                                    </td>
                                    <td>{{$product->sku}}</td>
                                    <td>{{\App\Manager\ProductVariationManager::calculateProductStock($product)}}</td>
                                    <td>
                                        @php $product_price  = \App\Manager\PriceCalculator::priceProcessor($product->price) @endphp
                                        @if($product_price['price'] == $product_price['payable_price'])
                                            <strong>৳{{number_format($product_price['payable_price'], 2)}}</strong>
                                        @else
                                            <p class="text-danger">
                                                <del>৳{{number_format($product_price['price'], 2)}}</del>
                                            </p>
                                            <p><strong>৳{{number_format($product_price['payable_price'], 2)}}</strong>
                                            </p>
                                        @endif


                                    </td>
                                    <td class="text-center">
                                        @if($product->is_published == \App\Models\Product::STATUS_LIST)
                                            <i class="ri-checkbox-circle-fill ri-xl text-success"></i>
                                        @else
                                            <i class="ri-close-circle-fill ri-xl text-danger"></i>
                                        @endif
                                    </td>
                                    <td>{{$product->created_by?->name}}</td>
                                    <td>{{$product->created_at->toDayDateTimeString()}}</td>
                                    <td>
                                        <a href="{{route('product.show', $product->id)}}">
                                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                        </a>
                                        <a href="{{route('product.edit', $product->id)}}">
                                            <button class="btn btn-sm btn-warning my-1"><i
                                                        class="ri-file-edit-line"></i></button>
                                        </a>
                                        {!! Form::open(['route'=>['product.destroy', $product->id], 'method'=>'delete']) !!}
                                        {!! Form::button('<i class="ri-delete-bin-line"></i>', ['class'=>'btn btn-sm btn-danger delete-product']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <p class="text-danger text-center">{{ __('No Data found') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- @if(Route::currentRouteName() == 'product.index')
                        <div class="form-group mt-2">
                            <div class="row">
                                <div class="col-lg-11 text-left">
                                    {{ $products->appends(['perPage' => $perPage])->links() }}
                                </div>
                                <div class="col-lg-1">
                                    @include('partials.pagination', ['pagination' => $products])
                                </div>
                            </div>
                        </div>
                    @else
                    <div class="form-group mt-2">
                        <div class="row">
                            <div class="col-lg-11 text-left">
                                {{ $products->appends(['perPage' => $perPage])->links() }}
                            </div>
                            <div class="col-lg-1">
                                @include('partials.pagination2', ['pagination' => $products])
                            </div>
                        </div>
                    </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>


    {{--    //csv_upload--}}
    <!-- Modal -->
    {{-- <div class="modal fade" id="csv_upload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Upload Product Using CSV</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <small class="text-danger">Please follow the standard csv formation as guided otherwise
                        functionality may behave unexpected</small>
                    {!! Form::open(['route'=>'product.import', 'method'=>'POST', 'files'=>true]) !!}
                    {!! Form::label('csv_file', 'Please Select Product CSV') !!}
                    {!! Form::file('csv_file', ['class'=>'form-control', 'accept'=>'.csv, text/csv']) !!}
                    {!! Form::button('Upload', ['class'=>'btn btn-success mt-3 float-end', 'type'=>'submit']) !!}
                    {!! Form::close() !!}
                    <button type="button" class="btn btn-danger mt-3" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}

@endsection
@push('script')
    <script>
        $('.delete-product').on('click', function () {
            Swal.fire({
                title: 'Are you sure to delete product?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent('form').submit()
                }
            })
        })
    </script>

    <script>
        function changePerPage() {
            var perPage = document.getElementById('perPage').value;
            window.location.href = "{{ route('product.index') }}?perPage=" + perPage;
        }
    </script>

    {{-- <script>
        function changePerPage2() {
            var perPage = document.getElementById('perPage').value;
            window.location.href = "{{ route('product.low_stock_product') }}?perPage=" + perPage;
        }
    </script> --}}
@endpush
