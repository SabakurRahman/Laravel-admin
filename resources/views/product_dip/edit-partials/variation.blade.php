<div class="tab-pane" id="variant" role="tabpanel" tabindex="0">
    <div class="row custom-input-group">
        <h6>Product Variation</h6>
        <div id="var_fields" data-attribute="{{json_encode($attributes, JSON_THROW_ON_ERROR)}}"></div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-3">
                <div class="d-grid">
                    <button type="button" class="btn btn-success" id="add_more_var_field"><i class="ri-add-line"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid">
                    <button type="button" class="btn btn-info" id="generate_combination"><i class="ri-add-line"></i>
                        Generate Combination
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="variation_display_area"></div>
</div>

<div id="product_variation_data_container" data-product-variation-data="{{json_encode($product->productVariations)}}"></div>

@include('modules.product.edit-partials.variant_script')
