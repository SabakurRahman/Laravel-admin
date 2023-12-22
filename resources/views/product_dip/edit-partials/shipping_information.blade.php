<div class="tab-pane fade" id="shipping_information" role="tabpanel">
    <div class="row">
        <h6>Delivery</h6>
        <p><span style="color: #0000006c;">Please Ensure you have entered the right package weight (kg) and dimensions
                (cm) for accurate shipping fee calculations. </span>.</p>
        <div class="row">
            <div class="col-md-12 mt-3">
                {!! Form::label('package_weight', 'Package Weight (Kg)') !!}
                {!! Form::text('package_weight', $product?->product_shipping?->package_weight, ['class' => 'form-control', 'placeholder' => 'Package Weight']) !!}
            </div>
        </div>

        <div class="row mt-3 mb-4">
            <div class="col-md-4">
                {!! Form::label('package_dimensions', 'Package Dimensions (cm)') !!}
                {!! Form::text('height', $product?->product_shipping?->height, ['class' => 'form-control', 'placeholder' => 'Height']) !!}
            </div>
            <div class="col-md-4 mt-4">
                {!! Form::text('width', $product?->product_shipping?->width, ['class' => 'form-control', 'placeholder' => 'Width']) !!}
            </div>
            <div class="col-md-4 mt-4">
                {!! Form::text('length', $product?->product_shipping?->length, ['class' => 'form-control', 'placeholder' => 'Length']) !!}
            </div>
            <div class="col-md-6 mt-4">
                {!! Form::label('dangerous_goods', 'Product Type') !!}
                @foreach (\App\Models\Product::DANGEROUS_GOODS_LIST as $key => $value)
                    <div class="form-check">
                        {!! Form::radio('dangerous_goods', $key, $product?->product_shipping?->dangerous_goods ==$key, [
                            'class' => 'form-check-input',
                            'id' => 'dangerous_goods' . $key,
                        ]) !!}
                        {!! Form::label('dangerous_goods' . $key, $value, ['class' => 'form-check-label']) !!}
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-6 mt-4">
                    {!! Form::label('delivery_charge_inside_dhaka', 'Additional Delivery Charge Inside Dhaka') !!}
                    {!! Form::text('delivery_charge_inside_dhaka', $product?->product_shipping?->delivery_charge_inside_dhaka, ['class' => 'form-control', 'placeholder' => 'Inside Dhaka']) !!}
                </div>
                <div class="col-md-6 mt-4">
                    {!! Form::label('delivery_charge_outside_dhaka', 'Additional Delivery Charge Outside Dhaka') !!}
                    {!! Form::text('delivery_charge_outside_dhaka', $product?->product_shipping?->delivery_charge_outside_dhaka, ['class' => 'form-control', 'placeholder' => 'Outside Dhaka']) !!}
                </div>
            </div>
        </div>
        <hr>
        <h6>Service</h6>
        <p><span style="color: #0000006c;">Sellers can opt to provide warrenty for the customers</span>.</p>

        <div class="row">
            <div class="col-md-6 mt-3">
                {!! Form::label('warrenty_type', 'Warrenty Type') !!}
                {!! Form::select('warrenty_type', \App\Models\Product::WARRANTY_TYPE_LIST, $product?->product_shipping?->warrenty_type, [
                    'class' => 'form-select',
                    'placeholder' => 'Select warranty Type',
                ]) !!}
            </div>

            <div class="col-md-6 mt-3 mb-3">
                {!! Form::label('warrenty_period', 'Warrenty Period') !!}
                {!! Form::select('warrenty_period', \App\Models\Product::WARRANTY_PERIOD_LIST,  $product?->product_shipping?->warrenty_period, [
                    'class' => 'form-select',
                    'placeholder' => 'Select Warrenty Period',
                ]) !!}
            </div>

            <h6>Warranty Policy</h6>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Bangla</span>
                        <input value="{{ $product?->product_shipping?->warrenty_policy_bn }}" type="text" class="form-control" placeholder="Warranty Policy Bangla" name="warrenty_policy_bn"
                            aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">English</span>
                        <input value="{{$product?->product_shipping?->warrenty_policy_en}}" type="text" class="form-control" placeholder="Warrenty Policy English" name="warrenty_policy_en"
                            aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
