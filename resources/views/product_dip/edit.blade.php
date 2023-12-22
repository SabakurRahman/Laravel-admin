@extends('layouts.admin-template.main')
@section('title', 'Update Product')
@section('main-content')
    <div class="row">
        <div class="mb-1">
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
            <a href="{{env('FRONTEND_URL').'/product-details/'.$product->slug}}" target="_blank">
                <button type="button" id="preview" class="btn btn-sm btn-theme mb-3 float-end me-2">
                    <i class="ri-eye-line"></i>
                    Preview
                </button>
            </a>

        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    @include('partials.flash')
                    @include('partials.validation_error_display')
                    <!-- Nav tabs -->
                    @include('modules.product.edit-partials.nav_tabs')
                    <!-- Tab panes -->
                    {{-- {!! Form::model($role, ['method'=>'put', 'route'=>['role.update', $role->id]]) !!} --}}
                    {!! Form::model($product, ['route' => ['product.update', $product->id], 'method' => 'put', 'id' => 'myForm', 'files' => true]) !!}

                    <div class="tab-content p-3 text-muted">
                        @include('modules.product.edit-partials.general')
                        {{-- @include('modules.product.edit-partials.product_data') --}}
                        {{-- @include('modules.product.edit-partials.links') --}}
                        {{-- @include('modules.product.edit-partials.shipping_information') --}}
                        @include('modules.product.edit-partials.attribute')
                        {{--                        @include('modules.product.partials.discount')--}}
                        @include('modules.product.edit-partials.images')
                        {{-- @include('modules.product.edit-partials.seo') --}}
                        {{-- @include('modules.product.edit-partials.variation')--}}
                    </div>
                    {!! Form::close() !!}
                    <div id="variation_data" data-variation="{{json_encode($product->productVariations)}}"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-none" data-attribute-value="{{json_encode($attribute_values)}}" id="attribute_values"></div>
    <div class="d-none" data-attribute-name="{{json_encode($attributes)}}" id="attribute_names"></div>
@endsection
@include('modules.product.edit-partials.script')
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
        $('#save_and_cont_product').on('click', function (){
            $('#myForm').append(`<input type="hidden" value="3" name="is_saved" />`).submit()
        })
    </script>
@endpush
