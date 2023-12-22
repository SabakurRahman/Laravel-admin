<div class="tab-pane fade" id="product_data" role="tabpanel">
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('model', 'Product model') !!}
            {!! Form::text('model', null, ['class' => 'form-control', 'placeholder' => 'Product model']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('sku', 'Product SKU') !!}
            {!! Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Product SKU']) !!}
        </div>
{{--        <div class="col-md-6 mt-3">--}}
{{--            {!! Form::label('gtin', 'Product GTIN') !!}--}}
{{--            {!! Form::text('gtin', null, ['class' => 'form-control', 'placeholder' => 'Product GTIN']) !!}--}}
{{--        </div>--}}
{{--        <div class="col-md-6 mt-3">--}}
{{--            {!! Form::label('mpn', 'Manufacturer part number') !!}--}}
{{--            {!! Form::text('mpn', null, ['class' => 'form-control', 'placeholder' => 'Manufacturer part number']) !!}--}}
{{--        </div>--}}
        <div class="col-md-6 mt-3">
            {!! Form::label('comment', 'Comment/Note') !!}
            {!! Form::text('comment', null, ['class' => 'form-control', 'placeholder' => 'Comment/Note']) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('accepted_payment_methods', 'Accepted Payment Method') !!}

            <select class="form-select select2"
                    multiple="multiple"
                    name="accepted_payment_methods[]"
            >
                <optgroup label="Select Tags">
                    @foreach($payment_methods as $key=>$value)
                        <option {{in_array($key,$product?->acceptedPaymentMethods?->pluck('id')->toArray()) ? 'selected' : null}} value="{{$key}}">{{$value}}</option>
                    @endforeach
                </optgroup>
            </select>
{{--            {!! Form::select('accepted_payment_methods[]', $payment_methods, null, ['class' => 'form-select select2', 'multiple'=>'multiple']) !!}--}}
        </div>
    </div>


    <hr class=" my-4 border-top">
    <h6>Inventory</h6>
    <div class="row align-items-center">
        <div class="col-md-6 mt-3">
            {!! Form::label('inventory_method', 'Inventory Method') !!}
            {!! Form::select('inventory_method', \App\Models\Inventory::INVENTORY_TRACK_LIST, $product->inventory->inventory_method, [
                'class' => 'form-select',
                'placeholder' => 'Select Inventory Method',
            ]) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('warehouses', 'Warehouses') !!}
            {!! Form::select('warehouses[]', $warehouses, null, [
                'class' => 'form-select select2',
                'multiple' => 'multiple'
            ]) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('stock', 'Stock') !!}
            {!! Form::number('stock', $product?->inventory?->stock, [
                'class' => 'form-control',
                'placeholder' => 'Stock', 'readonly' =>'readonly'
            ]) !!}
        </div>

        <div class="col-md-6 mt-3">
            {!! Form::label('low_stock_quantity', 'Low Stock Quantity') !!}
            {!! Form::number('low_stock_quantity', $product?->inventory?->low_stock_quantity, [
                'class' => 'form-control',
                'placeholder' => 'Low Stock Quantity'
            ]) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('min_cart_quantity', 'Minimum Cart Quantity') !!}
            {!! Form::number('min_cart_quantity', $product?->inventory?->min_cart_quantity, [
                'class' => 'form-control',
                'placeholder' => 'Minimum Cart Quantity',
            ]) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('max_cart_quantity', 'Maximum Cart Quantity') !!}
            {!! Form::number('max_cart_quantity', $product?->inventory?->max_cart_quantity, [
                'class' => 'form-control',
                'placeholder' => 'Maximum Cart Quantity',
            ]) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('allowed_quantity', 'Allowed quantities') !!}
            {!! Form::number('allowed_quantity', $product?->inventory?->allowed_quantity, [
                'class' => 'form-control',
                'placeholder' => 'Allowed quantities',
            ]) !!}
        </div>
        <div class="col-md-6 mt-3" data-asdf="{{ $product?->inventory?->available_date}}">
            {!! Form::label('available_date', 'Available date') !!}
            {!! Form::date('available_date', $product?->inventory?->available_date ? \Carbon\Carbon::create($product?->inventory?->available_date)->format('Y-m-d') : null, [
                'class' => 'form-control',
                'placeholder' => 'Available date',
            ]) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('available_alert_date', 'Available alert date') !!}
            {!! Form::date('available_alert_date',  $product?->inventory?->available_date ? \Carbon\Carbon::create($product?->inventory?->available_date)->format('Y-m-d') : null, ['class' => 'form-control', 'placeholder' => 'Available alert date']) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('expiry_date', 'Expiry Date') !!}
            {!! Form::date('expiry_date',  $product?->inventory?->expiry_date ? \Carbon\Carbon::create($product?->inventory?->expiry_date)->format('Y-m-d') : null, ['class' => 'form-control', 'placeholder' => 'Expiry Date']) !!}
        </div>
    </div>
    <hr class="my-4 border-top">
    <div class="row">
        <div class="col-md-6 mt-3">
            <div
                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                {!! Form::hidden('is_published', 0) !!}
                {!! Form::checkbox('is_published', 1, null, ['class' => 'form-check-input', 'id' => 'is_published']) !!}
                {!! Form::label('is_published', 'Product Publish', ['class' => 'form-check-label']) !!}
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div
                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                {!! Form::hidden('is_out_of_stock', 0) !!}
                {!! Form::checkbox('is_out_of_stock', 1, null, ['class' => 'form-check-input', 'id' => 'is_out_of_stock']) !!}
                {!! Form::label('is_out_of_stock', 'Mark as out of stock', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div
                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                {!! Form::hidden('is_show_on_home_page', 0) !!}
                {!! Form::checkbox('is_show_on_home_page', 1, null, ['class' => 'form-check-input', 'id' => 'is_show_on_home_page']) !!}
                {!! Form::label('is_show_on_home_page', 'Show on home page', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div
                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                {!! Form::hidden('is_new', 0) !!}
                {!! Form::checkbox('is_new', 1, null, ['class' => 'form-check-input', 'id' => 'is_new']) !!}
                {!! Form::label('is_new', 'Mark as New', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div
                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                {!! Form::hidden('is_dparcel', 0) !!}
                {!! Form::checkbox('is_dparcel', 1, null, ['class' => 'form-check-input', 'id' => 'is_dparcel']) !!}
                {!! Form::label('is_dparcel', 'Mark as dparcel', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div
                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                {!! Form::hidden('is_allow_customer_review', 0) !!}
                {!! Form::checkbox('is_allow_customer_review', 1, null, ['class' => 'form-check-input', 'id' => 'is_allow_customer_review']) !!}
                {!! Form::label('is_allow_customer_review', 'Allow Customer Review', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div
                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                {!! Form::hidden('disable_buy_button', 0) !!}
                {!! Form::checkbox('disable_buy_button', 1, $product?->inventory?->disable_buy_button, ['class' => 'form-check-input', 'id' => 'disable_buy_button']) !!}
                {!! Form::label('disable_buy_button', 'Disable Buy Button', ['class' => 'form-check-label']) !!}
            </div>
        </div>
{{--        <div class="col-md-6 mt-3">--}}
{{--            <div--}}
{{--                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">--}}
{{--                {!! Form::hidden('is_enable_call_for_price', 0) !!}--}}
{{--                {!! Form::checkbox('is_enable_call_for_price', 1, $product?->inventory?->is_enable_call_for_price, ['class' => 'form-check-input', 'id' => 'is_enable_call_for_price']) !!}--}}
{{--                {!! Form::label('is_enable_call_for_price', 'Call for price', ['class' => 'form-check-label']) !!}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="col-md-6 mt-3">--}}
{{--            <div--}}
{{--                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">--}}
{{--                {!! Form::hidden('is_available_for_pre_order', 0) !!}--}}
{{--                {!! Form::checkbox('is_available_for_pre_order', 1, $product?->inventory?->is_available_for_pre_order, [--}}
{{--                    'class' => 'form-check-input',--}}
{{--                    'id' => 'is_available_for_pre_order',--}}
{{--                ]) !!}--}}
{{--                {!! Form::label('is_available_for_pre_order', 'Available for pre-order', ['class' => 'form-check-label']) !!}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="col-md-6 mt-3">--}}
{{--            <div--}}
{{--                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">--}}
{{--                {!! Form::hidden('customer_enters_price', 0) !!}--}}
{{--                {!! Form::checkbox('customer_enters_price', 1, $product?->inventory?->customer_enters_price, [--}}
{{--                    'class' => 'form-check-input',--}}
{{--                    'id' => 'customer_enters_price',--}}
{{--                ]) !!}--}}
{{--                {!! Form::label('customer_enters_price', 'Customer enters price', ['class' => 'form-check-label']) !!}--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col-md-6 mt-3">
            <div
                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                {!! Form::hidden('is_tax_exempt', 0) !!}
                {!! Form::checkbox('is_tax_exempt', 1, $product?->inventory?->is_tax_exempt, ['class' => 'form-check-input', 'id' => 'is_tax_exempt']) !!}
                {!! Form::label('is_tax_exempt', 'Is Tax Exempt', ['class' => 'form-check-label']) !!}
            </div>
        </div>
{{--        <div class="col-md-6 mt-3">--}}
{{--            <div--}}
{{--                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">--}}
{{--                {!! Form::hidden('is_telecommunications_services', 0) !!}--}}
{{--                {!! Form::checkbox('is_telecommunications_services', 1, $product?->inventory?->is_telecommunications_services, [--}}
{{--                    'class' => 'form-check-input',--}}
{{--                    'id' => 'is_telecommunications_services',--}}
{{--                ]) !!}--}}
{{--                {!! Form::label('is_telecommunications_services', 'Telecommunications, broadcasting and electronic services', [--}}
{{--                    'class' => 'form-check-label',--}}
{{--                ]) !!}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-6 mt-3">--}}
{{--            <div--}}
{{--                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">--}}
{{--                {!! Form::hidden('disable_wishlist_button', 0) !!}--}}
{{--                {!! Form::checkbox('disable_wishlist_button', 1, $product?->inventory?->is_disable_wishlist_button, [--}}
{{--                    'class' => 'form-check-input',--}}
{{--                    'id' => 'disable_wishlist_button',--}}
{{--                ]) !!}--}}
{{--                {!! Form::label('disable_wishlist_button', 'Disable Wishlist Button', ['class' => 'form-check-label']) !!}--}}
{{--            </div>--}}
{{--        </div>--}}


        <div class="col-md-6 mt-3">
            <div
                class="form-check form-check-custom form-check-primary form-check-inline font-size-16">
                {!! Form::hidden('is_returnable', 0) !!}
                {!! Form::checkbox('is_returnable', 1, $product?->inventory?->is_returnable, [
                    'class' => 'form-check-input',
                    'id' => 'is_returnable',
                ]) !!}
                {!! Form::label('is_returnable', 'Not returnable', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        let previous_value = '{{$product?->price?->discount_type}}'
        if (previous_value = 1){
            $('#automatic_discount').slideDown()
            $('#discount-panel').slideDown()
        }else if(previous_value = 2){
            $('#manual_discount').slideDown()
            $('#discount-panel').slideDown()
        }else{
            $('#discount-panel').slideUp()
            $('#manual_discount').slideUp()
            $('#automatic_discount').slideUp()
        }


        $('input[name="discount_type"]').on('change', function () {
            let value = $(this).val()

            if (value == 1) {
                $('#automatic_discount').slideDown()
                $('#manual_discount').slideUp()
                $('#discount-panel').slideDown()
            } else if (value == 0){
                $('#automatic_discount').slideUp()
                $('#manual_discount').slideDown()
                $('#discount-panel').slideDown()
            }else{
                $('#discount-panel').slideUp()
                $('#manual_discount').slideUp()
                $('#automatic_discount').slideUp()
            }
        })
    </script>
@endpush
