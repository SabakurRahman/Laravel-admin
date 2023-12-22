<div class="tab-pane fade" id="links" role="tabpanel">
    <div class="row">
        <div class="col-md-6 mt-3">
            {!! Form::label('categories_select', 'Categories') !!}
            <select data-placeholder="Select Category" id="categories_select" name="category_id[]"
                    class="form-select select2"
                    multiple="multiple">
                <optgroup label="Select Categories">
                    @foreach ($categories as $category)
                        <option {{in_array($category->id, $product?->categories?->pluck('id')?->toArray()) ? 'selected': null}} value="{{ $category->id }}">
                            {{ $category->getFullHierarchyAttribute() }}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('manufacturer_id', 'Manufacturer') !!}
            {!! Form::select('manufacturer_id', $manufacturers, true, [
                'class' => 'form-select',
                'placeholder' => 'Select a manufacturer ',
            ]) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('store_id', 'Stores') !!}
            <select  class="form-select select2"
                     multiple="multiple"
                     name="store_id[]"
            >
                <optgroup label="Select Stores">
                    @foreach($stores as $key=>$value)
                        <option {{in_array($key, $product?->stores?->pluck('id')?->toArray()) ? 'selected' : null}} value="{{$key}}">{{$value}}</option>
                    @endforeach
                </optgroup>
            </select>
{{--            {!! Form::select('store_id[]', $stores, null, ['class' => 'form-select select2', 'data-placeholder' => 'Select Stores', 'multiple'=>true]) !!}--}}
        </div>
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

            <select class="form-select select2"
                     multiple="multiple"
                    name="related_products[]"
            >
                <optgroup label="Select Product">
                    @foreach($products as $key=>$value)
                        <option {{in_array($key,$product?->relatedProducts?->pluck('related_product_id')->toArray()) ? 'selected' : null}} value="{{$key}}">{{$value}}</option>
                    @endforeach
                </optgroup>
            </select>

{{--            {!! Form::select('related_products[]', $products, null, ['class' => 'form-select select2', 'multiple' => 'multiple']) !!}--}}
        </div>
        <div class="col-md-6 mt-3">
            <label for="cross_products" data-bs-toggle="tooltip" title="Related products shows on cart page">Cross Sale
                <i class="ri-information-fill info-icon"></i></label>


            <select class="form-select select2"
                    multiple="multiple"
                    name="cross_products[]"
            >
                <optgroup label="Select Product">
                    @foreach($products as $key=>$value)
                        <option {{in_array($key,$product?->crossProduct?->pluck('cross_product_id')->toArray()) ? 'selected' : null}} value="{{$key}}">{{$value}}</option>
                    @endforeach
                </optgroup>
            </select>

{{--            {!! Form::select('cross_products[]', $products, null, ['class' => 'form-select select2', 'multiple' => 'multiple']) !!}--}}
        </div>
        <div class="col-md-6 mt-3">
            <label for="tags" data-bs-toggle="tooltip" title="Product tags for better seo and sorting">Product Tags
                <i class="ri-information-fill info-icon"></i></label>
            <select class="form-select select2"
                    multiple="multiple"
                    name="tags[]"
            >
                <optgroup label="Select Tags">
                    @foreach($tags as $key=>$value)
                        <option {{in_array($key,$product?->productTags?->pluck('id')->toArray()) ? 'selected' : null}} value="{{$key}}">{{$value}}</option>
                    @endforeach
                </optgroup>
            </select>
{{--           {!! Form::select('tags[]', $tags, null, ['class' => 'form-select select2', 'multiple' => 'multiple']) !!}--}}
        </div>
    </div>

</div>
