<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/1.8.0/tom-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/1.8.0/tom-select.min.js"></script>
<style>
    .productLabelStyle label {
        font-size: 16px !important;
    }

    .label-style {
        margin-top: 20px;
    }

    .checkboxStyle label {
        margin-top: 0 !important;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .space {
        /* justify-content:space-between; */
        margin-right: 5px !important;
    }

    .border-area {
        /* border: 1px solid rgba(191, 32, 47, 0.25);
        border-radius:5px; */
        /* padding:2px 10px 5px 10px!important; */
        /* margin-bottom: 18px!important; */
    }

    .delete-design {
        display: block;
        margin-left: auto;
    }

    .specification-div-style {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: #fff;
        background-clip: padding-box;
        /* border: 1px solid #dee2e6;; */
        border-radius: 0.375rem;
    }

    .size {
        font-size: 14px !important;
    }
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li class="flex-wrap nav-item">
                        <a class="nav-link waves-effect waves-light active" data-bs-toggle="tab" href="#home"
                           role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block size">Basic</span>
                        </a>
                    </li>

                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#maps" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block size">Mapping</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#inventory" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block size">Inventory</span>
                        </a>
                    </li>


                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#Prices" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block size">Price</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#images" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block size">Photo</span>
                        </a>
                    </li>

                    {{-- ******** --}}

                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#specification" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block size">Specification</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#shipping" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block size">Shipping</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#warrenty" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block size">Warrenty</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#faqs" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block size">Faq</span>
                        </a>
                    </li>


                </ul>
                <!-- Tab panes -->
                <div class="pt-3 tab-content text-muted productLabelStyle">

                    {{-- /Product Information --}}
                    <div class="tab-pane active" id="home" role="tabpanel">
                        <fieldset>
                            <div class="row custom-input-group">
                                <div class="col-md-6">
                                    {!! Form::label('title', 'Product Name') !!}
                                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Product Name', 'id' => 'title']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('slug', 'Slug') !!}
                                    {!! Form::text('slug', null, ['class'=>'form-control', 'placeholder'=>'Enter Slug']) !!}
                                </div>
                            </div>

                            <div class="custom-input-group">
                                {!! Form::label('description', 'Description') !!}
                                {{-- {!! Form::textarea('description', null, ['class' => 'form-control tinymce', 'placeholder' => 'Enter Description']) !!} --}}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Write here...', 'id' => 'elm1']) !!}
                            </div>
                            <div class="row custom-input-group">
                                <div class="col-md-6">
                                    {!! Form::label('short_description', 'Short description') !!}
                                    {!! Form::textarea('short_description', null, ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Write here...', 'name' => 'short_description', 'cols' => 50, 'id' => 'short_description']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('comment', 'Comment') !!}
                                    {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Write Comment...', 'name' => 'comment', 'cols' => 50, 'id' => 'comment']) !!}
                                </div>
                            </div>
                            <div class="row custom-input-group">
                                {{-- <div class="col-md-6">
                                    {!! Form::label('product_type', 'Product type', ['class' => 'label-style']) !!}
                                    {!! Form::select('product_type', \App\Models\Product::PRODUCT_TYPE_LIST, $selectedProductType, ['class' => 'form-select', 'placeholder' => 'Select Product Type']) !!}
                                </div> --}}
                                <div class="col-md-6">
                                    {!! Form::label('product_type', 'Product type',['class'=>'label-style']) !!}
                                    {!! Form::select('product_type', \App\Models\Product::PRODUCT_TYPE_LIST,null, ['class'=>'form-select', 'placeholder'=>'Select Product Type']) !!}
                                </div>


                                <div class="col-md-6">
                                    {!! Form::label('sort_order', 'Sorting Order') !!}
                                    {!! Form::input('number', 'sort_order', null, ['class' => 'form-control', 'placeholder' => 'Write here...', 'id' => 'sort_order']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('sku', 'SKU') !!}
                                    {!! Form::input('text', 'sku', null, ['class' => 'form-control', 'placeholder' => 'Write here...', 'id' => 'sku']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('model', 'Model') !!}
                                    {!! Form::input('text', 'model', null, ['class' => 'form-control', 'placeholder' => 'Write here...', 'id' => 'model']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('is_published', 'Publish type',['class'=>'label-style']) !!}
                                    {!! Form::select('is_published', \App\Models\Product::STATUS_LIST, null, ['class'=>'form-select', 'placeholder'=>'Select Product Type']) !!}
                                </div>


                            </div>


                            <div style="margin-top:20px" class="row checkboxStyle">
                                <div class="mt-3 col-md-6">
                                    <div
                                        class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                                        {!! Form::hidden('is_show_on_home_page', '2') !!}
                                        {!! Form::checkbox('is_show_on_home_page', '1', old('is_show_on_home_page', $product->is_show_on_home_page == 1), ['class' => 'form-check-input', 'id' => 'is_show_on_home_page']) !!}
                                        {!! Form::label('is_show_on_home_page', 'Show on home page', ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div
                                        class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                                        {!! Form::hidden('is_allow_review', '2') !!}
                                        {!! Form::checkbox('is_allow_review', '1', old('is_allow_review', $product->is_allow_review == 1), ['class' => 'form-check-input', 'id' => 'is_allow_review']) !!}
                                        {!! Form::label('iis_allow_review', 'Allow Customer Add Review', ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div
                                        class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                                        {!! Form::hidden('is_new', '2') !!}
                                        {!! Form::checkbox('is_new', '1', old('is_new', $product->is_new == 1), ['class' => 'form-check-input', 'id' => 'is_new']) !!}
                                        {!! Form::label('is_new', 'Mark as New', ['class' => 'form-check-label']) !!}
                                    </div>

                                </div>
                                <div class="mt-3 col-md-6">
                                    <div
                                        class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                                        {!! Form::hidden('is_prime', '2') !!}
                                        {!! Form::checkbox('is_prime', '1',old('is_prime', $product->is_prime == 1), ['class' => 'form-check-input', 'id' => 'is_prime'])!!}
                                        {!! Form::label('is_prime', 'Mark as Prime', ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>

                            </div>
                        </fieldset>
                        <fieldset class="mt-4">
                            <legend>Seo</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::label('meta_title', ' Seo Title') !!}
                                    {!! Form::text('meta_title',$product->seos->title ?? null, ['class'=>'form-control', 'placeholder'=>'Enter blog category title']) !!}
                                </div>

                                <div class="col-md-6">
                                    {!! Form::label('meta_title_bn', 'Seo Title_bn') !!}
                                    {!! Form::text('meta_title_bn',$product->seos->title_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter seo title bn']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('meta_keywords', 'Keywords') !!}
                                    {!! Form::text('meta_keywords', $product->seos->keywords ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords']) !!}
                                </div>

                                <div class="col-md-6">
                                    {!! Form::label('meta_keywords_bn', 'Keywords bn') !!}
                                    {!! Form::text('meta_keywords_bn', $product->seos->keywords_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords bn']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('meta_description', 'Seo Description ') !!}
                                    {!! Form::text('meta_description', $product->seos->description ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('meta_description_bn', 'Seo Description bn ') !!}
                                    {!! Form::text('meta_description_bn', $product->seos->description_bn ??null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description bn ']) !!}
                                </div>

                                <div class="col-md-8">
                                    {!! Form::label('og_image', 'Og image',['class'=>'label-style']) !!}
                                    {!! Form::file('og_image', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Og image']) !!}
                                    <div class="photo-preview-area" style="width: 250px; height: 150px">
                                        <i class="ri-camera-line"></i>
                                        <div class="overly"></div>
                                        <img
                                            src="{{isset($product?->seos?->og_image) ? asset(\App\Models\Seo::Seo_PHOTO_UPLOAD_PATH . $product?->seos?->og_image)  : asset('uploads/canvas.webp')}}"
                                            alt="photo display area" class="photo photo-preview-area-photo"/>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    {{-- /Product Mapping --}}

                    <div class="tab-pane" id="maps" role="tabpanel">
                        <fieldset>
                            <div class="row custom-input-group">
                                <div class="col-md-6">
                                    {!! Form::label('category_ids', 'Categories', ['class' => 'label-style']) !!}
                                    {!! Form::select('category_ids[]',
                                        ['' => 'Select Parent Category'] + $parentCategory->mapWithKeys(function($category) {
                                            return [$category->id => $category->getFullHierarchyAttribute()];
                                        })->toArray(),
                                        old('category_ids', $selectedCategories),
                                        ['class' => 'form-select select2 select2-multiple', 'multiple' => true]) !!}
                                    <p style="font-size: 13px !important; margin-top: 3px !important"> [ you can select
                                        multiple ] </p>
                                </div>

                                <div class="col-md-6">
                                    {!! Form::label('manufacturer_id', 'Manufacture') !!}
                                    {!! Form::select('manufacturer_id', $manufactures ?? [], null, ['class' => 'form-select', 'placeholder' => 'Select Manufacture']) !!}

                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('country_id', 'Product Origin', ['class' => 'label-style']) !!}
                                    {!! Form::select('country_id', $countries ?? [], null, ['class' => 'form-select', 'placeholder' => 'Select Country']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('vendor_id', 'Vendor') !!}
                                    {!! Form::select('vendor_id', $vendors ?? [], null, ['class' => 'form-select', 'placeholder' => 'Select Vendor']) !!}
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    {{-- /inventory --}}
                    <div class="tab-pane" id="inventory" role="tabpanel">
                        <fieldset>
                            <div class="row custom-input-group align-items-center">
                                <div class="mt-3 col-md-6 custom-input-group">
                                    {!! Form::label('payment_method_ids', 'Accepted Payment Method', ['class' => 'label-style']) !!}
                                    {!! Form::select('payment_method_ids[]', $paymentMethods ?? [], $selectedPaymentMethods, ['class' => 'form-select select2 select2-multiple', 'multiple' => true]) !!}
                                    <p style="font-size:13px!important;margin-top:3px!important"> [ you can select
                                        multiple ] </p>
                                    {{-- {!! Form::select('payment_method_ids[]', $paymentMethods ?? [], null, ['class' => 'form-select select2 select2-multiple', 'multiple' => true]) !!} --}}
                                </div>
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('warehouse_ids', 'Warehouses') !!}
                                    {!! Form::select('warehouse_ids[]', $warehouses ?? [], $selectedwarehouses, ['class' => 'form-select select2 select2-multiple', 'multiple' => true]) !!}
                                    <p style="font-size:13px!important;margin-top:3px!important"> [ you can select
                                        multiple ] </p>
                                    {{-- {!! Form::select('warehouse_ids[]', $warehouses ?? [], null, ['class' => 'form-select select2 select2-multiple', 'multiple' => true]) !!} --}}
                                </div>
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('inventory_method', 'Inventory Method') !!}
                                    {!! Form::select('inventory_method', ['' => 'Select Inventory Method', '1' => 'Track Inventory', '0' => 'Don\'t Track Inventory'], old('inventory_method',optional($product->inventories)->inventory_method), ['class' => 'form-select', 'id' => 'inventory_method']) !!}
                                </div>
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('stock', 'Stock') !!}
                                    {!! Form::number('stock',old('stock',optional($product->inventories)->stock), ['class' => 'form-control', 'placeholder' => 'Stock']) !!}
                                </div>
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('min_cart_quantity', 'Minimum Cart Quantity') !!}
                                    {!! Form::number('min_cart_quantity', old('min_cart_quantity', optional($product->inventories)->min_cart_quantity), ['class' => 'form-control', 'placeholder' => 'Minimum Cart Quantity']) !!}
                                </div>
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('max_cart_quantity', 'Maximum Cart Quantity') !!}
                                    {!! Form::number('max_cart_quantity',old('max_cart_quantity',optional($product->inventories)->max_cart_quantity), ['class' => 'form-control', 'placeholder' => 'Maximum Cart Quantity']) !!}
                                </div>
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('available_date', 'Available date') !!}
                                    {!! Form::datetimeLocal('available_date',old('available_date', optional($product->inventories)->available_date), ['class' => 'form-control', 'placeholder' => 'Available date']) !!}
                                </div>
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('ralatedProduct_ids', 'Related Products') !!}
                                    {!! Form::select('ralatedProduct_ids[]', $relatedProducts ?? [], $selectedRelatedProducts, ['class' => 'form-select select2 select2-multiple', 'multiple' => true]) !!}
                                    <p style="font-size:13px!important;margin-top:3px!important"> [ you can select
                                        multiple ] </p>
                                    {{-- {!! Form::select('ralatedProduct_ids[]', $relatedProducts ?? [], null, ['class' => 'form-select select2 select2-multiple', 'multiple' => true]) !!} --}}
                                </div>
                            </div>
                            <div style="margin-top:20px" class="row custom-input-group checkboxStyle">
                                <div class="mt-3 col-md-6">
                                    <div
                                        class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                                        {!! Form::hidden('is_available_for_pre_order', 0) !!}
                                        {{-- {!! Form::checkbox('is_available_for_pre_order', 1, old('is_available_for_pre_order', $inventoryInformation->is_available_for_pre_order == 1), ['class' => 'form-check-input', 'id' => 'is_available_for_pre_order']) !!} --}}
                                        {!! Form::checkbox('is_available_for_pre_order', 1, old('is_available_for_pre_order', optional($product->inventories)->is_available_for_pre_order == 1), ['class' => 'form-check-input', 'id' => 'is_available_for_pre_order']) !!}
                                        {!! Form::label('is_available_for_pre_order', 'Available For Pre-Order', ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>

                                <div class="mt-3 col-md-6">
                                    <div
                                        class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                                        {!! Form::hidden('is_enable_call_for_price', 0) !!}
                                        {!! Form::checkbox('is_enable_call_for_price', 1, old('is_enable_call_for_price', optional($product->inventories)->is_enable_call_for_price == 1), ['class' => 'form-check-input', 'id' => 'is_enable_call_for_price']) !!}
                                        {!! Form::label('is_enable_call_for_price', 'Call for Price', ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div
                                        class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                                        {!! Form::hidden('is_returnable', 0) !!}
                                        {!! Form::checkbox('is_returnable', 1, old('is_returnable', optional($product->inventories)->is_returnable == 1), ['class' => 'form-check-input', 'id' => 'is_returnable']) !!}
                                        {!! Form::label('is_returnable', 'Not returnable', ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div
                                        class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                                        {!! Form::hidden('disable_buy_button', 0) !!}
                                        {!! Form::checkbox('disable_buy_button', 1, old('disable_buy_button', optional($product->inventories)->disable_buy_button == 1), ['class' => 'form-check-input', 'id' => 'disable_buy_button']) !!}
                                        {!! Form::label('disable_buy_button', 'Disable Buy Button', ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div
                                        class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                                        {!! Form::hidden('is_disable_wishlist_button', 0) !!}
                                        {!! Form::checkbox('is_disable_wishlist_button', 1, old('is_disable_wishlist_button', optional($product->inventories)->is_disable_wishlist_button == 1), ['class' => 'form-check-input', 'id' => 'is_disable_wishlist_button']) !!}
                                        {!! Form::label('is_disable_wishlist_button', 'Disable wishlist button', ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>

                                <div class="mt-3 col-md-6">
                                    <div
                                        class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                                        {!! Form::hidden('low_stock_alert', 1) !!}
                                        {!! Form::checkbox('low_stock_alert', 0, old('low_stock_alert', optional($product->inventories)->low_stock_alert == 0), ['class' => 'form-check-input', 'id' => 'low_stock_alert']) !!}
                                        {!! Form::label('low_stock_alert', 'Low stock alart', ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    {{-- /Specification--}}
                    <div class="tab-pane" id="specification" role="tabpanel">
                        <fieldset>
                            <div class="row custom-input-group" id="specification-container">
                                @foreach ($product->specifications ??[] as $index => $specification)
                                    <div class="specification-group border-area">
                                        <div class="d-flex ">
                                            <div style="margin-right:34px!important" class="mx-2 col-md-5">
                                                {!! Form::label('name', 'Name') !!}
                                                {!! Form::text("specifications[${index}][name]", $specification->name, ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
                                            </div>
                                            <div style="margin-right:35px!important" class="mx-2 col-md-5">
                                                {!! Form::label('value', 'Value') !!}
                                                {!! Form::text("specifications[${index}][value]", $specification->value, ['class' => 'form-control', 'placeholder' => 'Enter Value']) !!}
                                            </div>
                                            <div class="col-md-5">
                                                <button style="top: 35px;position: relative;" type="button"
                                                        class="btn btn-danger delete-specification-row"
                                                        data-index="{{ $index }}"><i style="color:white"
                                                                                     class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <button style="display:block;margin:auto;width:10%;" type="button"
                                        class="mt-1 btn btn-outline-theme" id="add-specification"><i
                                        style="font-size:15px" class="ri-add-line"></i></button>
                            </div>
                        </fieldset>
                    </div>

                    {{-- /Price--}}
                    <div class="tab-pane" id="Prices" role="tabpanel">
                        <fieldset>
                            <div class="row custom-input-group">
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('price', 'Sale Price') !!}
                                    <i data-bs-toggle="tooltip" title="Product regular selling price per unit"
                                       class="ri-information-fill info-icon"></i>
                                    {!! Form::number('price', old('price',optional($product->product_price)->price), ['class' => 'form-control', 'placeholder' => 'Sale Price']) !!}
                                    {{-- {!! Form::number('price', old('price', $productprice?? $product->price), ['class' => 'form-control', 'placeholder' => 'Sale Price']) !!} --}}
                                </div>
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('cost', 'Product Cost') !!}
                                    <i data-bs-toggle="tooltip" title="Product Cost per unit"
                                       class="ri-information-fill info-icon"></i>
                                    {!! Form::number('cost', old('cost',optional($product->product_price)->cost), ['class' => 'form-control', 'placeholder' => 'Product Cost']) !!}
                                </div>
                            </div>
                            <h6 class="mt-3">Discount Type
                                {!! Form::label(null, null, ['data-bs-toggle' => 'tooltip', 'title' => 'Discount can be set manually by giving previous price and discount test on the other hand it can be automated by giving fixed or percentage or both amount', 'class' => 'ri-information-fill info-icon']) !!}
                            </h6>
                            <div class="checkboxStyle">
                                <div class="mt-3 form-check form-check-inline">
                                    {!! Form::radio('discount_type', '2', old('discount_type', optional($product->product_price)->discount_type) == '2', ['class' => 'form-check-input', 'id' => 'discount_type_none']) !!}
                                    {!! Form::label('discount_type_none', 'None', ['class' => 'form-check-label']) !!}
                                </div>
                                <div class="mt-3 form-check form-check-inline">
                                    {!! Form::radio('discount_type', '0', old('discount_type', optional($product->product_price)->discount_type) == '0', ['class' => 'form-check-input', 'id' => 'discount_type_manual']) !!}
                                    {!! Form::label('discount_type_manual', 'Manual', ['class' => 'form-check-label']) !!}
                                </div>
                                <div class="mt-3 form-check form-check-inline">
                                    {!! Form::radio('discount_type', '1', old('discount_type', optional($product->product_price)->discount_type) == '1', ['class' => 'form-check-input', 'id' => 'discount_type_auto']) !!}
                                    {!! Form::label('discount_type_auto', 'Auto', ['class' => 'form-check-label']) !!}
                                </div>
                            </div>

                            <div class="row"
                                 style="{{ (optional($product->product_price)->discount_type == '0') ? '' : 'display: none' }}"
                                 id="manual_discount">
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('discount_info', 'Discount info', ['data-bs-toggle' => 'tooltip', 'title' => 'Discount info will show in a label in product card']) !!}
                                    {!! Form::text('discount_info', old('discount_info',optional($product->product_price)->discount_info), ['class' => 'form-control', 'placeholder' => '10% OFF']) !!}
                                </div>
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('old_price', 'Old Price', ['data-bs-toggle' => 'tooltip', 'title' => 'For discount you can manually add previous price']) !!}
                                    {!! Form::number('old_price', old('old_price',optional($product->product_price)->old_price), ['class' => 'form-control', 'placeholder' => '500']) !!}
                                </div>
                            </div>
                            <div class="row"
                                 style="{{ (optional($product->product_price)->discount_type == '1') ? '' : 'display: none' }}"
                                 id="automatic_discount">
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('discount_fixed', 'Discount fixed amount') !!}
                                    <i data-bs-toggle="tooltip" title="Discount fixed amount like 100tk"
                                       class="ri-information-fill info-icon"></i>
                                    {!! Form::number('discount_fixed', old('discount_fixed',optional($product->product_price)->discount_fixed), ['class' => 'form-control', 'placeholder' => '100', 'id' => 'discount_fixed']) !!}
                                </div>
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('discount_percent', 'Discount percentage') !!}
                                    <i data-bs-toggle="tooltip" title="Discount percentage amount like 10%"
                                       class="ri-information-fill info-icon"></i>
                                    {!! Form::number('discount_percent', old('discount_percent',optional($product->product_price)->discount_percent), ['class' => 'form-control', 'placeholder' => '10%', 'id' => 'discount_percent']) !!}
                                </div>

                            </div>
                            <div class="row"
                                 style="{{ (optional($product->product_price)->discount_type == '0' || optional($product->product_price)->discount_type == '1') ? '' : 'display: none' }}"
                                 id="discount-panel">
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('discount_start', 'Discount Start Date') !!}
                                    <i data-bs-toggle="tooltip"
                                       title="Discount start date can be specified on the other hand can leave it empty to apply discount all time"
                                       class="ri-information-fill info-icon"></i>
                                    {!! Form::datetimeLocal('discount_start', old('discount_start',optional($product->product_price)->discount_start), ['class' => 'form-control', 'placeholder' => 'Discount Start Date', 'id' => 'discount_start']) !!}
                                </div>
                                <div class="mt-3 col-md-6">
                                    {!! Form::label('discount_end', 'Discount End Date') !!}
                                    <i data-bs-toggle="tooltip"
                                       title="Discount end date can be specified on the other hand can leave it empty to apply discount all time"
                                       class="ri-information-fill info-icon"></i>
                                    {!! Form::datetimeLocal('discount_end', old('discount_end',optional($product->product_price)->discount_end), ['class' => 'form-control', 'placeholder' => 'Discount End Date', 'id' => 'discount_end']) !!}
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    {{-- /Photo--}}
                    <div class="tab-pane fade" id="images" role="tabpanel">
                        <fieldset>
                            {{-- <div class="mt-3" id="product_photo_display_row">
                                <!-- Display existing photos -->
                                @if(isset($product))
                                    @foreach ($product->ProductPhotos as $index => $photo)
                                        <!-- Existing photo display -->
                                        <div class="mb-4 row align-items-center" id="photo_preview_row_{{ $index }}">
                                            <div class="col-md-3">
                                                <img src="{{ asset('uploads/product/' . $photo->photo) }}" alt="Preview photo" class="img-thumbnail product-image-upload-display"/>
                                                <input type="hidden" name="photos[{{ $index }}][photo]" value="{{ $photo->photo }}">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row align-items-end">
                                                    <!-- Display order, alt text, title -->
                                                    <div class="col-md-3">
                                                        <label class="mb-0 w-100">
                                                            Display Order
                                                            <input name="photos[{{ $index }}][serial]" value="{{ $photo->serial }}" type="number" class="form-control">
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="mb-0 w-100">
                                                            Alt Text
                                                            <input name="photos[{{ $index }}][alt_text]" value="{{ $photo->alt_text }}" type="text" class="form-control">
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="mb-0 w-100">
                                                            Title
                                                            <input name="photos[{{ $index }}][title]" value="{{ $photo->title }}" type="text" class="form-control">
                                                        </label>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" data-index="{{ $index }}" class="btn btn-danger delete-product-display-row">
                                                            <i style="color:white" class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <!-- Display newly added photos during update -->
                                @if(isset($newPhotos))
                                    @foreach ($newPhotos as $index => $newPhoto)
                                        <!-- New photo display -->
                                        <div class="mb-4 row align-items-center" id="photo_preview_row_new_{{ $index }}">
                                            <div class="col-md-3">
                                                <img src="{{ $newPhoto['photo'] }}" alt="Preview photo" class="img-thumbnail product-image-upload-display"/>
                                                <input type="hidden" name="photos[new_{{ $index }}][photo]" value="{{ $newPhoto['photo'] }}">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row align-items-end">
                                                    <!-- New photo display order, alt text, title -->
                                                   <div class="col-md-3">
                                                        <label class="mb-0 w-100">
                                                            Display Order
                                                            <input name="photos[new_{{ $index }}][serial]" value="{{ $newPhoto['serial'] }}" type="number" class="form-control">
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="mb-0 w-100">
                                                            Alt Text
                                                            <input name="photos[new_{{ $index }}][alt_text]" value="{{ $newPhoto['alt_text'] }}" type="text" class="form-control">
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="mb-0 w-100">
                                                            Title
                                                            <input name="photos[new_{{ $index }}][title]" value="{{ $newPhoto['title'] }}" type="text" class="form-control">
                                                        </label>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <button type="button" data-index="new_{{ $index }}" class="btn btn-danger delete-product-display-row">
                                                            <i style="color:white" class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="my-5 row justify-content-center">
                                <!-- Add functionality to upload images for the product with the given ID -->
                                <div class="col-md-4">
                                    <label style="width:270px" class="mb-0">
                                        <p style="font-size:15px;margin-bottom:3px!important;">
                                            Please Select Images ({{ \App\Models\ProductPhoto::PHOTO_WIDTH }}px X {{ \App\Models\ProductPhoto::PHOTO_HEIGHT }}px)
                                        </p>
                                        <input id="images" name="photos[]" type="file" class="form-control" multiple>
                                    </label>
                                </div>
                            </div> --}}

                            <div class="mt-3" id="product_photo_display_row">
                                @foreach ($product->ProductPhotos as $index => $photo)

                                    <div class="mb-4 row align-items-center" id="photo_preview_row_{{ $index }}">
                                        <div class="col-md-3">
                                            <img src="{{ asset('uploads/product/' . $photo->photo) }}"
                                                 alt="Preview photo"
                                                 class="img-thumbnail product-image-upload-display"/>
                                            <input type="hidden" name="photos[{{ $index }}][photo]"
                                                   value="{{ $photo->photo }}">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row align-items-end">
                                                <div class="col-md-3">
                                                    <label class="mb-0 w-100">
                                                        Display Order
                                                        <input name="photos[{{ $index }}][serial]"
                                                               value="{{ $photo->serial }}" type="number"
                                                               class="form-control">
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="mb-0 w-100">
                                                        Alt Text
                                                        <input name="photos[{{ $index }}][alt_text]"
                                                               value="{{ $photo->alt_text }}" type="text"
                                                               class="form-control">
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="mb-0 w-100">
                                                        Title
                                                        <input name="photos[{{ $index }}][title]"
                                                               value="{{ $photo->title }}" type="text"
                                                               class="form-control">
                                                    </label>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" data-index="{{ $index }}"
                                                            class="btn btn-danger delete-product-display-row">
                                                        <i style="color:white" class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="my-5 row justify-content-center">
                                <!-- Add functionality to upload images for the product with the given ID -->
                                <div class="col-md-4">
                                    <label style="width:270px" class="mb-0">
                                        <p style="font-size:15px;margin-bottom:3px!important;">
                                            Please Select Images ({{ \App\Models\ProductPhoto::PHOTO_WIDTH }}px
                                            X {{ \App\Models\ProductPhoto::PHOTO_HEIGHT }}px)
                                        </p>
                                        <input id="images" type="file" class="form-control" multiple>
                                    </label>
                                </div>
                            </div>


                            <div class="row custom-input-group" id="product_variation_display_area"
                                 style="display: none">
                                <h6>Product Variation</h6>
                                <div id="var_fields"
                                     data-attribute="{{json_encode($attributes, JSON_THROW_ON_ERROR)}}"></div>
                                <div id="attribute_fields"
                                     data-attribute="{{json_encode($attributes, JSON_THROW_ON_ERROR)}}"></div>

                                <div class="mt-4 row justify-content-center">
                                    <div class="col-md-3">
                                        <div class="d-grid">
                                            <button type="button" class="btn btn-success" id="add_more_var_field"><i
                                                    class="ri-add-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-grid">
                                            <button type="button" class="btn btn-info" id="generate_combination"><i
                                                    class="ri-add-line"></i>
                                                Generate Combination
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="variation_display_area"></div>
                        </fieldset>
                    </div>
                    {{-- @include('product.image_upload_script') --}}

                    {{-- /FAQ--}}
                    <div class="tab-pane" id="faqs" role="tabpanel">
                        <div style="margin-left:5px!important;margin-right:5px!important;"
                             class="row custom-input-group" id="faq-container">
                            @foreach ($product->faqs as $index => $faq)
                                <div class="faq-group border-area">
                                    <div class="d-flex ">
                                        <div class="mt-3 col-md-6 space">
                                            {!! FORM::label('question_title', 'Question') !!}
                                            {!! FORM::text("faqs[$index][question_title]", $faq->question_title, ['class' => 'form-control', 'placeholder' => 'Enter Question']) !!}
                                        </div>
                                        <div class="mt-3 col-md-6">
                                            {!! Form::label('description', 'Answer') !!}
                                            {!! FORM::text("faqs[$index][description]", $faq->description, ['class' => 'form-control', 'placeholder' => 'Enter description']) !!}
                                        </div>
                                    </div>
                                    <div class="mt-3 col-md-6 ">
                                        {!! Form::label('Status', 'Status', ['class' => 'label-style']) !!}
                                        {!! Form::select("faqs[$index][status]", \App\Models\Faq::STATUS_LIST, $faq->status, ['class' => 'form-select', 'placeholder' => 'Select Status']) !!}
                                    </div>

                                    <div class="col-md-1 delete-design">
                                        <button type="button" class="btn btn-danger delete-faq-row"
                                                data-index="{{ $index }}"><i style="color:white"
                                                                             class="ri-delete-bin-line"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button style="display:block;margin:auto;" type="button" class="mt-2 btn btn-outline-theme"
                                id="add-faq"><i style="font-size:25px" class="ri-add-line"></i></button>
                    </div>

                    {{-- SHIPPING --}}
                    <div class="tab-pane" id="shipping" role="tabpanel">
                        <fieldset>
                            <div class="row">
                                <div class="row custom-input-group">
                                    <div class="col-md-6">
                                        {!! Form::label('package_weight', 'Package Weight (Kg)') !!}
                                        {!! Form::number('package_weight', old('package_weight', optional($product->shipping)->package_weight), ['class'=>'form-control', 'placeholder'=>'write here']) !!}

                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('product_shipping_type', 'Product Type') !!}
                                        {!! Form::select('product_shipping_type', \App\Models\Shipping::PRODUCT_TYPE_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Product Type']) !!}
                                    </div>
                                </div>
                                <h6 class="my-2">Package Dimensions (Cm)
                                    {!! Form::label(null, null, ['data-bs-toggle' => 'tooltip', 'title' => 'Package Dimension Information', 'class' => 'ri-information-fill info-icon']) !!}
                                </h6>
                                <div class="row custom-input-group">
                                    <div class="col-md-4">
                                        {!! Form::label('height', 'Height') !!}
                                        {!! Form::number('height', old('height', optional($product->shipping)->height), ['class'=>'form-control', 'placeholder'=>'Enter Height']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::label('width', 'Width') !!}
                                        {!! Form::number('width', old('width',optional($product->shipping)->width), ['class'=>'form-control', 'placeholder'=>'Enter Width']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::label('length', 'Length') !!}
                                        {!! Form::number('length',old('length', optional($product->shipping)->length), ['class'=>'form-control', 'placeholder'=>'Enter Length']) !!}
                                    </div>
                                </div>


                            </div>

                        </fieldset>
                    </div>
                    {{-- Warrenty --}}
                    <div class="tab-pane" id="warrenty" role="tabpanel">
                        <fieldset>
                            <div class="row">
                                <div class="row custom-input-group">
                                    <div class="col-md-6">
                                        {!! Form::label('warrenty_type', 'Warrenty Type') !!}
                                        {!! Form::select('warrenty_type', \App\Models\Warrenty::WARRENTY_TYPE_LIST , old('warrenty_type', optional($product->warrenty)->warrenty_type), ['class'=>'form-select', 'placeholder'=>'Select Warrenty Type']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('warrenty_period', 'Warrenty Period') !!}
                                        {!! Form::select('warrenty_period', \App\Models\Warrenty::WARRENTY_PERIOD_LIST , old('warrenty_period', optional($product->warrenty)->warrenty_period), ['class'=>'form-select', 'placeholder'=>'Select Warrenty Period']) !!}
                                    </div>
                                    <div class="col-md-12">
                                        {!! Form::label('warrenty_policy', 'Warrenty Policy') !!}
                                        {!! Form::text('warrenty_policy', old('warrenty_policy', optional($product->warrenty)->warrenty_policy), ['class'=>'form-control', 'placeholder'=>'write Warrenty Policy']) !!}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    {{-- <script>
        const categories = {!! json_encode($categories) !!};

        function flattenCategories(categories) {
            let flattenedCategories = [];

            categories.forEach(category => {
                // Check if the category has subcategories
                if (category.subcategories.length > 0) {
                    const subcategoryOptions = flattenCategories(category.subcategories);

                    subcategoryOptions.forEach(option => {
                        // Prefix the subcategory name with the parent category name
                        option.text = category.name + ' >> ' + option.text;
                        flattenedCategories.push(option);
                    });
                } else {
                    flattenedCategories.push({ id: category.id, text: category.name });
                }
            });

            return flattenedCategories;
        }

        const flattenedCategories = flattenCategories(categories);

        // Populate the select element
        const selectElement = document.getElementById('category-select');
        flattenedCategories.forEach(category => {
            const option = new Option(category.text, category.id, false, false);
            selectElement.add(option);
        });
    </script> --}}

    {{-- Multiple select --}}
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
    {{-- for variation add --}}
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

        $(document).ready(function () {
            $('#categories_select').select2();
        });
    </script>
    {{-- for variation update --}}
    <script>
        $('#name').on('input', function (e) {
            $('#slug').val(formatSlug($(this).val()))
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

        $(document).ready(function () {
            $('#categories_select').select2();
        });
    </script>

    <script>
        let tomSelectInstances = new Map();
        let attribute_names = JSON.parse($('#attribute_names').attr('data-attribute-name'))
        let selected_names = []
        let var_indexs = [0]
        const generateVarElement = (index, data) => {
            return `<div class="mt-3 row align-items-end var_single_row" id="var_single_row_${index}">
            <div class="col-md-11">
                <div class="row">
                <div class="col-md-5">
                    <label class="mb-0 w-100">
                        Select Variant Name
                        <select name="var_attribute[${index}][attribute_id]" type="text" data-index="${index}" class="form-select attribute-variation-name">
                            <option disabled selected>Select Variant Name</option>
                            ${data}
                        </select>
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="mb-0 w-100">
                        Variant Value
                        <input name="var_attribute[${index}][value]" type="text" id="tom_select_${index}" class="tom-select attribute-variation-value">
                    </label>
                </div>
            </div>
            </div>
            <div class="col-md-1">
              <button type="button" data-index="${index}" class="btn btn-outline-danger remove-var">
                <i class="ri-delete-bin-line"></i>
              </button>
            </div>
        </div>`
        }
        const handleProductPhotoToVariationPhoto = () => {
            return $(document).find('input[name="photos[0][photo]"]').val();
        }
        const displayVarElement = () => {
            let field_element = $('#var_fields')
            let data = JSON.parse(field_element.attr('data-attribute'))
            let var_element_data = generateVarElement(var_indexs[var_indexs.length - 1], prepareVarOptions(data))
            field_element.append(var_element_data);
        }

        const prepareVarOptions = (data) => {
            let options = ``
            for (const [key, value] of Object.entries(data)) {
                options += `<option value="${key}">${value}</option>`
            }
            return options
        }


        $('#add_more_var_field').on('click', function () {
            let new_index = var_indexs[var_indexs.length - 1] + 1
            console.log(attribute_names.length)
            if (Object.keys(attribute_names).length > new_index) {
                var_indexs.push(new_index)
                displayVarElement()
                tomSelectInstances.set(`tom_select_${new_index}`, handleTomSelect(`#tom_select_${new_index}`))
            }
        })

        displayVarElement()

        $(document).on('click', '.remove-var', function () {
            let id = $(this).attr('data-index')
            $(`#var_single_row_${id}`).remove()
            var_indexs.splice(id, 1)
        })

        const handleTomSelect = (elem, tom_data = undefined) => {
            return new TomSelect(elem, {
                plugins: ['remove_button'],
                persist: false,
                createOnBlur: true,
                create: true,
                valueField: 'title',
                labelField: 'title',
                searchField: 'title',
                options: tom_data,
            });
        }

        tomSelectInstances.set('tom_select_0', handleTomSelect(`#tom_select_0`))

        $(document).on('change', '.attribute-variation-name', function () {
            let value = $(this).val()
            let index = $(this).attr('data-index')
            let attribute_values = JSON.parse($('#attribute_values').attr('data-attribute-value'))
            let tom_data = []
            let filtered_data = attribute_values.filter((attribute_value, index) => {
                if (attribute_value.attribute_id == value) {
                    tom_data = [...tom_data, {title: attribute_value.name}]
                    return attribute_value
                }
            })
            let element = tomSelectInstances.get(`tom_select_${index}`)
            console.log(attribute_values)
            element.clear();
            element.clearOptions()
            element.addOption(tom_data)
        })


        $('#generate_combination').on('click', function () {

            let image = handleProductPhotoToVariationPhoto()
            if (image == undefined) {
                image = window.location.origin + '/images/default.webp'
            }
            let price = $('input[name="price"]').val()
            if (price == undefined) {
                price = ''
            }
            let stock = $('input[name="stock"]').val()
            if (stock == undefined) {
                stock = ''
            }


            let combination_data = {}
            $('.var_single_row').each(function (i, obj) {
                let name_id = $(this).find('.attribute-variation-name').val()
                let name_name = $(this).find('.attribute-variation-name').children(':selected').text()
                let value = $(this).find('.attribute-variation-value').val()
                combination_data[name_name] = value.split(',')
            });

            let combinations = []
            for (const [attr, values] of Object.entries(combination_data)) {
                combinations.push(values.map(v => ({[attr]: v})));
            }
            combinations = combinations.reduce((a, b) => a.flatMap(d => b.map(e => ({...d, ...e}))));

            let variation_element_string = ``
            for (const index in Object.entries(combinations)) {
                variation_element_string += generateVariationSingleRow(index, combinations[index], image, price, stock)
            }
            $('#variation_display_area').html(variation_element_string)

        })

        const prepareVariationTitle = (title_data) => {
            let string = ``
            for (const [attr, value] of Object.entries(title_data)) {
                string += `<button type="button" class="btn btn-sm btn-secondary me-1">${attr} : ${value}</button>`
            }
            return string
        }

        const generateVariationSingleRow = (index, data, image, price, stock) => {
            return `<div class="mt-4 card" id="generate_var_single_row_${index}">
            <div class="card-header">
                <h6>${prepareVariationTitle(data)}</h6>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <input type="hidden" data-index="${index}" name="variations[${index}][data]" value='${JSON.stringify(data)}'>
                        <div class="position-relative variation-image-display-area">
                            <img alt="preview photo" src="${image}" data-index="${index}"
                                     class="img-thumbnail product-image-upload-display"/>
                                <input name="variations[${index}][photo]" type="file" class="d-none variation_photo_input">
                            <div class="var-image-overly-black"></div>
                            <div class="var-image-overly">
                                <button style="margin-top:5px!important" type="button" class="btn btn-success variation_photo_display_trigger">
                                    Change Image</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row align-items-end">
                            <div class="col-md-5">
                                <label class="w-100">
                                    Price
                                    <input data-index="${index}" type="number" name="variations[${index}][price]" value="${price}" class="form-control">
                                </label>
                            </div>
                            <div class="col-md-5">
                                <label class="w-100">
                                    Stock
                                    <input data-index="${index}" type="number" name="variations[${index}][stock]" value="${stock}" class="form-control">
                                </label>
                            </div>
                            <div class="col-md-2">
                                <div class="d-grid">
                                    <button type="button" class="btn btn-danger" data-index="${index}"
                                    id="remove_variation_row">
                                    <i class="ri-delete-bin-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`
        }


        //image handler
        $(document).on('click', '.variation_photo_display_trigger', function () {
            $(this).parent('.var-image-overly').siblings('input').trigger('click')
        })

        $(document).on('change', '.variation_photo_input', function (e) {
            let img = e.target.files[0]
            $(this).siblings('img').attr('src', URL.createObjectURL(img))
        })

        $(document).on('click', '#remove_variation_row', function () {
            let id = $(this).attr('data-index')
            $(`#generate_var_single_row_${id}`).remove()
            var_indexs.splice(id, 1)
        })

        //handle default
        // $(document).on('click', '.set-default', function () {
        //     $('.set-default').each(function (key, element) {
        //         $(this).prop("checked", false)
        //     })
        //     $(this).prop('checked', true)
        // })

        //during_edit
        let variation_data = JSON.parse($('#variation_data').attr('data-variation'))
        console.log('variation_data', variation_data)
        if (variation_data != undefined) {
            let variation_element_string = ``
            variation_data.map((variation, index) => {
                let image = "{{url(\App\Models\ProductPhoto::PHOTO_UPLOAD_PATH_THUMB)}}/" + variation?.product_variation_photo?.photo
                let price = variation?.product_price?.price
                let stock = variation?.product_inventory?.stock
                let title_data = {}
                variation?.variation_attributes.map((attribute, attr_ind) => {
                    let key = attribute?.product_attribute?.name
                    let value = attribute?.value
                    title_data = {...title_data, [key]: value}
                })
                variation_element_string += generateVariationSingleRow(index, title_data, image, price, stock)
            })
            $('#variation_display_area').html(variation_element_string)
        }


    </script>

@endpush

