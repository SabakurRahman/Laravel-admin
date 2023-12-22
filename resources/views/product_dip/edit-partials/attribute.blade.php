<div class="tab-pane fade" id="attribute" role="tabpanel">
    <h6>Product Attribute</h6>
    <div id="attribute_fields" data-attribute="{{json_encode($attributes, JSON_THROW_ON_ERROR)}}"></div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-2">
            <div class="d-grid">
                <button type="button" class="btn btn-success" id="add_more_attribute_field">
                    <i class="ri-add-line"></i></button>
            </div>
        </div>
    </div>
    <h6>Product Specifications</h6>
    <div id="specifications_fields"></div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-2">
            <div class="d-grid">
                <button type="button" class="btn btn-success" id="add_more_specifications_field">
                    <i class="ri-add-line"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="d-none" id="product_specification_data_container" data-product-specification="{{json_encode($product->productSpecification)}}"></div>
<div class="d-none" id="product_attribute_data_container" data-product-attribute="{{json_encode($product->productAttributes)}}"></div>
@include('modules.product.edit-partials.attribute_script')
@include('modules.product.edit-partials.specifications_script')
