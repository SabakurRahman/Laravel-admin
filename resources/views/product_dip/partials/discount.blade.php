<div class="tab-pane fade" id="discount" role="tabpanel">

    <div class="row">
        <div class="col-md-6  mt-3">
            {!! Form::label('customer_group', 'Customer Group:') !!}
            {!! Form::select('customer_group', [], null, [
                'class' => 'form-control',
                'placeholder' => 'Select a customer group',
            ]) !!}
        </div>
        <div class="col-md-6  mt-3">
            {!! Form::label('discount_id', 'Discounts') !!}
            {!! Form::select('discount_id', [], null, [
                'class' => 'form-control',
                'placeholder' => 'Select discount',
            ]) !!}
        </div>

        <div class="col-md-6  mt-3">
            {!! Form::label('quantity', 'Quantity') !!}
            {!! Form::text('quantity', null, ['class' => 'form-control', 'placeholder' => 'Quantity']) !!}
        </div>

        <div class="col-md-6 mt-3">
            {!! Form::label('priority', 'Priority') !!}
            {!! Form::text('priority', null, ['class' => 'form-control', 'placeholder' => 'Priority']) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('price', 'Price') !!}
            {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Price']) !!}
        </div>

        <div class="col-md-6 mt-3">
            {!! Form::label('date_start', 'Date Start') !!}
            {!! Form::date('date_start', null, ['class' => 'form-control', 'placeholder' => 'Date Start']) !!}
        </div>

        <div class="col-md-6 mt-3">
            {!! Form::label('date_end', 'Date End') !!}
            {!! Form::date('date_end', null, ['class' => 'form-control', 'placeholder' => 'Date End']) !!}
        </div>
    </div>


</div>
