@extends('layouts.admin-template.main')
@section('title', 'Bulk Product Edit')
@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="">
                        <button class="btn btn-sm btn-theme mb-3">
                            <i class="ri-save-line"></i> Save
                        </button>
                    </a>
                    <a href="">
                        <button class="btn btn-sm btn-danger mb-3">
                            <i class="ri-close-line"></i> Cancel
                        </button>
                    </a>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>View</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Old price</th>
                                <th>Manage inventory</th>
                                <th>Stock qty</th>
                                <th>Published</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)
                                <tr data-data="{{json_encode($product->id)}}">
                                    <td data-column="name">
                                        {{$product->name}}
                                    </td>
                                    <td>
                                        <a href="{{route('product.show', $product->id)}}">
                                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                        </a>
                                    </td>
                                    <td data-column="sku">{{$product->sku}}</td>
                                    <td data-column="price">{{$product?->price?->price}}</td>
                                    <td data-column="old_price">{{$product?->price?->old_price}}</td>
                                    <td data-column="inventory_method">{{$product?->inventory?->inventory_method}}</td>
                                    <td data-column="stock">{{$product?->inventory?->stock}}</td>
                                    <td data-column="is_published" class="text-center">
                                        {{$product->is_published}}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i>
                                        </button>
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
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>


    {{--    //csv_upload--}}
    <!-- Modal -->
    <div class="modal fade" id="csv_upload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
    </div>

@endsection
@push('css')
    <link href="{{asset('lib/assets/css/style.css')}}" type="text/css" rel="stylesheet">
@endpush

@push('script')
    <script src="{{asset('lib/assets/js/app.js')}}"></script>
    <script src="{{asset('lib/assets/js/domEdit.js')}}"></script>
@endpush
