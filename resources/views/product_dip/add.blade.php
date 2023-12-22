@extends('frontend.layouts.master')
@section('title', 'Add Product')
@section('main-content')
    <div class="row">
        {{-- <div class="mb-1">
            <a href="{{route('product.index')}}" type="button" class="btn btn-sm btn-theme mb-3 float-end">
                <i class="ri-list-check"></i>
                Product List
            </a>
            <button type="button" id="save_product" class="btn btn-sm btn-theme mb-3 float-end me-2">
                <i class="ri-save-line"></i>
                Save
            </button>
            <button type="button" id="draft_product" class="btn btn-sm btn-theme mb-3 float-end me-2">
                <i class="ri-draft-line"></i>
                Draft
            </button>
            <button type="button" id="preview" class="btn btn-sm btn-theme mb-3 float-end me-2">
                <i class="ri-eye-line"></i>
                Preview
            </button>
        </div> --}}
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{-- @include('partials.flash') --}}
                    {{-- @include('partials.validation_error_display') --}}
                    <!-- Nav tabs -->
                    {{-- @include('modules.product.partials.nav_tabs') --}}
                    <!-- Tab panes -->
                    {!! Form::open(['route'=>'product.store', 'method'=>'post', 'id'=>'myForm', 'files'=>true]) !!}
                    <div class="tab-content p-3 text-muted">
                        @include('product.partials.general')
                        {{-- @include('modules.product.partials.product_data') --}}
                        {{-- @include('modules.product.partials.links') --}}
                        {{-- @include('modules.product.partials.shipping_information') --}}
                        @include('product.partials.attribute')
                        {{--                        @include('modules.product.partials.discount')--}}
                        @include('product.partials.images')
                        {{-- @include('modules.product.partials.seo') --}}
                        @include('product.partials.variation')
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="d-none" data-attribute-value="{{json_encode($attribute_values)}}" id="attribute_values"></div>
    <div class="d-none" data-attribute-name="{{json_encode($attributes)}}" id="attribute_names"></div> --}}
@endsection
@include('product.partials.script')
@push('css')
    <style>
        .select2-results__option[aria-selected=true] {
            display: none;
        }
    </style>
@endpush
@push('script')
    <script>
        $('#save_product').on('click', function () {
           $('#myForm').append(`<input type="hidden" value="1" name="is_saved" />`).submit()
        })
        $('#draft_product').on('click', function () {
           $('#myForm').append(`<input type="hidden" value="2" name="is_saved" />`).submit()
        })
        $('#preview').on('click', function () {
            Swal.fire('Please save/draft before preview')
        })
    </script>
@endpush
