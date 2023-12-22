<div class="tab-pane fade" id="images" role="tabpanel">
    <div id="product_photo_display_row">

    </div>
    <div class="row justify-content-center my-5">
        <div class="col-md-4">
            <label class="w-100 mb-0">
                Please Select Images ({{\App\Models\ProductPhoto::PHOTO_WIDTH}}px X {{\App\Models\ProductPhoto::PHOTO_HEIGHT}}px)
                <input id="images" type="file" class="form-control" multiple>
            </label>
        </div>
    </div>

    <div class="row custom-input-group" id="product_variation_display_area" style="display: none">
        <h6>Product Variation</h6>
        {{-- <div id="var_fields" data-attribute="{{json_encode($attributes, JSON_THROW_ON_ERROR)}}"></div> --}}
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
@include('product.partials.image_upload_script')
