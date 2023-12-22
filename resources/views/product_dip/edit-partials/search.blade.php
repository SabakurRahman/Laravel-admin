{!! Form::open(['method'=>'get', 'id'=>'product_search_form']) !!}
<div class="row mb-4" id="product_search_area">
    <div class="col-md-4 mb-3">
        {!! Form::label('name', 'Product Name') !!}
        {!! Form::text('name',  $filter['name'] ?? null, ['class'=>'form-control', 'placeholder'=> 'Enter Product Name']) !!}
    </div>

    <div class="col-md-4 mb-3">
        {!! Form::label('sku', 'Product SKU') !!}
        {!! Form::text('sku',  $filter['sku'] ?? null, ['class'=>'form-control', 'placeholder'=> 'Enter Product SKU']) !!}
    </div>


    <div class="col-md-4 mb-3">
        {!! Form::label('warehouse_id', 'Warehouses') !!}
         {!! Form::select('warehouse_id', $warehouses, $filter['warehouse_id'] ?? null, ['class'=>'form-control', 'placeholder'=> 'Select Warehouse']) !!}
    </div>

    <div class="col-md-4 mb-3">
        {!! Form::label('category_id', 'Category') !!}
        <select name="category_id" class="form-select">
            <option value="0">Select Category</option>
            @foreach($categories as $category)
                <option {{ isset($filter['category_id']) && $filter['category_id'] == $category->id ? 'selected': null}} value="{{$category->id}}">{{$category->getFullHierarchyAttribute()}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-3">
        {!! Form::label('product_type', 'Product type') !!}
            {!! Form::select('product_type', \App\Models\Product::PRODUCT_TYPE_LIST, $filter['product_type'] ?? null,
            [
                'class' => 'form-select',
                'placeholder' => 'Select Product Type',
            ]) !!}
    </div>

    <div class="col-md-4 mb-3">
        {!! Form::label('vendor_id', 'Vendor') !!}
         {!! Form::select('vendor_id', $vendors, $filter['vendor_id'] ?? null, ['class'=>'form-control', 'placeholder'=> 'Select Vendor']) !!}
    </div>

    <div class="col-md-4 mb-3">
        {!! Form::label('manufacturer_id', 'Manufacturers') !!}
         {!! Form::select('manufacturer_id', $manufacturers, $filter['manufacturer_id'] ?? null, ['class'=>'form-control', 'placeholder'=> 'Select Manufacturer']) !!}
    </div>

    <div class="col-md-4 mb-3">
        {!! Form::label('discount', 'Discount product') !!}
            {!! Form::select('discount', \App\Models\Product::DISCOUNT_PRODUCT_LIST, $filter['discount'] ?? null,
            [
                'class' => 'form-select',
                'placeholder' => 'Select option',
            ]) !!}
    </div>


    <div class="col-md-4 mb-3">
        {!! Form::label('is_published', 'Published') !!}
            {!! Form::select('is_published', \App\Models\Product::STATUS_LIST, $filter['is_published'] ?? null,
            [
                'class' => 'form-select',
                'placeholder' => 'ALL',
            ]) !!}
    </div>
</div>
<div class="row justify-content-center mb-5">
    <div class="col-md-3">
        <div class="d-grid">
            <button id="reset_search_form" type="reset" class="btn btn-outline-warning"><i class="ri-refresh-line"></i> Reset Filters</button>
        </div>
    </div>
    <div class="col-md-3">
        <div class="d-grid">
            {!! Form::button('<i class="ri-search-line"></i> Search', ['type'=>'submit', 'class'=>'btn btn-outline-success']) !!}
        </div>
    </div>
</div>

{!! Form::close() !!}

@push('script')
    <script>
        $('#reset_search_form').on('click', function () {
            resetFilters()
        })
    </script>
@endpush
