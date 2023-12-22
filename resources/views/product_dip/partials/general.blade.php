<div class="tab-pane active" id="general" role="tabpanel" tabindex="0">
    <div class="row custom-input-group">
        <div class="col-md-6">
            {!! Form::label('product_type', 'Product type') !!}
            {!! Form::select('product_type', \App\Models\Product::PRODUCT_TYPE_LIST, null, [
                'class' => 'form-select',
                'placeholder' => 'Select Product Type',
            ]) !!}
        </div>
    </div>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active d-flex" data-bs-toggle="tab" href="#english" role="tab">
                <img class="icon-image me-1" src="{{ asset('images/icons/flag_uk.svg') }}"
                     alt="Flag of UK">
                <span class="d-none d-sm-block">English</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex" data-bs-toggle="tab" href="#bangla" role="tab">
                <img class="icon-image me-1" src="{{ asset('images/icons/flag_bn.svg') }}"
                     alt="Flag of bangladesh">
                <span class="d-none d-sm-block">Bengali</span>
            </a>
        </li>
    </ul>
    <div class="tab-content p-3 text-muted">
        <div class="tab-pane active" id="english" role="tabpanel">
            <div class="custom-input-group">
                {!! Form::label('name', 'Product Name') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Product Name']) !!}
            </div>
            <div class="custom-input-group">
                {!! Form::label('slug', 'Product Url') !!}
                {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Product Url']) !!}
            </div>
            <div class="custom-input-group">
                {!! Form::label('short_description', 'Product short description') !!}
                {!! Form::textarea('short_description', null, ['class' => 'form-control', 'rows'=>5, 'placeholder' => 'Product short description']) !!}
            </div>
            <div class="custom-input-group">
                {!! Form::label('description', 'Product description') !!}
                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Product description']) !!}
            </div>
        </div>
        <div class="tab-pane" id="bangla" role="tabpanel">
            <div class="custom-input-group">
                {!! Form::label('name_bn', 'Product Name') !!}
                {!! Form::text('name_bn', null, ['class' => 'form-control', 'placeholder' => 'Product Name in Bengali']) !!}
            </div>
            <div class="custom-input-group">
                {!! Form::label('slug_bn', 'Product Url BN') !!}
                {!! Form::text('slug_bn', null, ['class' => 'form-control', 'placeholder' => 'Product Url BN']) !!}
            </div>
            <div class="custom-input-group">
                {!! Form::label('short_description_bn', 'Product short description') !!}
                {!! Form::textarea('short_description_bn', null, [
                    'class' => 'form-control',
                    'rows' =>5,
                    'placeholder' => 'Product short description in Bengali',
                ]) !!}
            </div>
            <div class="custom-input-group">
                {!! Form::label('description_bn', 'Product description') !!}
                {!! Form::textarea('description_bn', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Product description in Bengali',
                ]) !!}
            </div>
        </div>
    </div>

    <hr class="my-4 border-top">
    <h6>Prices</h6>
    <div class="row">
        <div class="col-md-6 mt-3">
            <label for="price" data-bs-toggle="tooltip" title="Product regular selling price per unit"> Sale Price<i
                    class="ri-information-fill info-icon"></i></label>
            {!! Form::number('price', null, ['class' => 'form-control', 'placeholder' => 'Sale Price']) !!}
        </div>
        <div class="col-md-6 mt-3">
            <label for="cost" data-bs-toggle="tooltip"
                   title="Product Cost per unit"> Product Cost<i
                    class="ri-information-fill info-icon"></i></label>
            {!! Form::number('cost', null, ['class' => 'form-control', 'placeholder' => 'Product Cost']) !!}
        </div>
    </div>

    <h6 class="mt-3">Discount Type
        <i
            data-bs-toggle="tooltip"
            title="Discount can be set manually by giving previous price and discount test on the other hand it can be automated by giving fixed or percentage or both amount"
            class="ri-information-fill info-icon"
        ></i></h6>
    <div class="form-check mt-3 form-check-inline">
        <input checked value="2" class="form-check-input" type="radio" name="discount_type" id="discount_type_none">
        <label class="form-check-label" for="discount_type_none">
            None
        </label>
    </div>
    <div class="form-check mt-3 form-check-inline">
        <input value="0" class="form-check-input" type="radio" name="discount_type" id="discount_type_manual">
        <label class="form-check-label" for="discount_type_manual">
            Manual
        </label>
    </div>
    <div class="form-check mt-3 form-check-inline">
        <input value="1" class="form-check-input" type="radio" name="discount_type" id="discount_type_auto">
        <label class="form-check-label" for="discount_type_auto">
            Auto
        </label>
    </div>
    <div class="row" style="display: none" id="manual_discount">
        <div class="col-md-6 mt-3">
            <label for="discount_info" data-bs-toggle="tooltip"
                   title="Discount info will show in a label in product card"> Discount info<i
                    class="ri-information-fill info-icon"></i></label>
            {!! Form::text('discount_info', null, ['class' => 'form-control', 'placeholder' => '10% OFF']) !!}
        </div>
        <div class="col-md-6 mt-3">
            <label for="previous_price" data-bs-toggle="tooltip"
                   title="For discount you can manually add previous price"> Old Price<i
                    class="ri-information-fill info-icon"></i></label>
            {!! Form::number('previous_price', null, ['class' => 'form-control', 'placeholder' => '500']) !!}
        </div>
    </div>
    <div class="row" style="display: none" id="automatic_discount">
        <div class="col-md-6 mt-3">
            {!! Form::label('discount_fixed', 'Discount fixed amount') !!}
            <i
                data-bs-toggle="tooltip"
                title="Discount fixed amount like 100tk"
                class="ri-information-fill info-icon"
            ></i>
            {!! Form::number('discount_fixed', null, ['class' => 'form-control', 'placeholder' => '100']) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('discount_percent', 'Discount percentage') !!}
            <i
                data-bs-toggle="tooltip"
                title="Discount percentage amount like 10%"
                class="ri-information-fill info-icon"
            ></i>
            {!! Form::number('discount_percent', null, ['class' => 'form-control', 'placeholder' => '10%']) !!}
        </div>
    </div>
    <div class="row" style="display: none" id="discount-panel">
        <div class="col-md-6 mt-3">
            {!! Form::label('discount_start', 'Discount Start Date') !!}
            <i
                data-bs-toggle="tooltip"
                title="Discount start date can be specified on the other hand can leave it empty to apply discount all time"
                class="ri-information-fill info-icon"
            ></i>
            {!! Form::datetimeLocal('discount_start', null, ['class' => 'form-control', 'placeholder' => 'Discount  Start Date']) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('discount_end', 'Discount End Date') !!}
            <i
                data-bs-toggle="tooltip"
                title="Discount end date can be specified on the other hand can leave it empty to apply discount all time"
                class="ri-information-fill info-icon"
            ></i>
            {!! Form::datetimeLocal('discount_end', null, ['class' => 'form-control', 'placeholder' => 'Discount  End Date']) !!}
        </div>
    </div>


    {{--    <div class="row">--}}
    {{--        <div class="col-md-6 mt-3">--}}
    {{--            {!! Form::label('tax_category_id', 'Tax Category') !!}--}}
    {{--            {!! Form::select('tax_category_id', [], null, [--}}
    {{--                'class' => 'form-select',--}}
    {{--                'placeholder' => 'Select Tax Category',--}}
    {{--            ]) !!}--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <hr class="my-4 border-top">
    <h6>Product Mapping</h6>

    <div class="row">
        <div class="col-md-6 mt-3">
            {!! Form::label('categories_select', 'Categories') !!}
            <select data-placeholder="Select Category" id="categories_select" name="category_id[]"
                    class="form-select select2"
                    multiple="multiple">
                <optgroup label="Select Categories">
                    @foreach ($product->categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->getFullHierarchyAttribute() }}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('manufacturer_id', 'Manufacturer') !!}
            {!! Form::select('manufacturer_id', $manufactures, null, [
                'class' => 'form-select select2',
                'placeholder' => 'Select a manufacturer ',
            ]) !!}
        </div>
        {{-- <div class="col-md-6 mt-3">
            {!! Form::label('store_id', 'Stores') !!}
            {!! Form::select('store_id[]', $stores, null, ['class' => 'form-select select2', 'data-placeholder' => 'Select Stores', 'multiple'=>true]) !!}
        </div> --}}
        <div class="col-md-6 mt-3">
            {!! Form::label('vendor_id', 'Vendor') !!}
            {!! Form::select('vendor_id', $vendors, null, ['class' => 'form-select select2', 'placeholder' => 'Select Vendor']) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('country_id', 'Product Origin') !!}
            {!! Form::select('country_id', $countries, null, ['class' => 'form-select select2', 'placeholder' => 'Select product origin']) !!}
        </div>
        <div class="col-md-6 mt-3">
            <label for="related_products" data-bs-toggle="tooltip" title="Related products shows on cart page">Related
                Products <i class="ri-information-fill info-icon"></i></label>
            {!! Form::select('related_products[]', $relatedProducts, null, ['class' => 'form-select select2', 'multiple' => 'multiple']) !!}
        </div>
        {{-- <div class="col-md-6 mt-3">
            <label for="cross_products" data-bs-toggle="tooltip" title="Related products shows on cart page">Cross Sale
                <i class="ri-information-fill info-icon"></i></label>
            {!! Form::select('cross_products[]', $products, null, ['class' => 'form-select select2', 'multiple' => 'multiple']) !!}
        </div> --}}
        <div class="col-md-6 mt-3">
            <label for="tags" data-bs-toggle="tooltip" title="Product tags for better seo and sorting">Product Tags
                <i class="ri-information-fill info-icon"></i></label>
            {!! Form::select('tags[]', $tags, null, ['class' => 'form-select select2', 'multiple' => 'multiple']) !!}
        </div>
    </div>


</div>
@push('script')
    <script>
        $('#name').on('input', function (e) {
            let name = $(this).val()
            $('#slug').val(formatSlug(name))
            $('#title').val(name)
            $('#keywords-ts-control').val(name.replaceAll(' ', ', '))
            console.log(name.replaceAll(' ', ','))
        })
        $('#name_bn').on('input', function (e) {
            $('#slug_bn').val(formatSlug($(this).val()))
        })
        $('#product_type').on('change', function () {
            let value = $(this).val()
            if (value == '{{\App\Models\Product::PRODUCT_TYPE_GROUPED}}') {
                $('#product_variation_display_area').slideDown()
                $('#variation_display_area').slideDown()
            } else {
                $('#product_variation_display_area').slideUp()
                $('#variation_display_area').slideUp()
            }
        })

        $(document).ready(function() {
            $('#categories_select').select2();
        });
    </script>
@endpush
