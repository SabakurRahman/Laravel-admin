{!! Form::open(['method'=>'get', 'class'=>'mb-4']) !!}
<div class="card">
    <div class="card-body">
        <div class="row align-items-end">
            <div class="col-md-3">
                {!! Form::label('start_date') !!}
                {!! Form::date('start_date', isset($filters['start_date']) ? $filters['start_date'] : null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('end_date') !!}
                {!! Form::date('end_date', isset($filters['end_date']) ? $filters['end_date'] : null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('invoice_no') !!}
                {!! Form::text('invoice_no', isset($filters['invoice_no']) ? $filters['invoice_no'] : null, ['class'=>'form-control form-control-sm','placeholder' => 'Enter Invoice No']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('order_status') !!}
                {!! Form::select('order_status',App\Models\Order::ORDER_STATUS_LIST, isset($filters['order_status']) ? $filters['order_status'] : null, ['class'=>'form-control form-control-sm','placeholder' => 'Order Pending']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('payment_status') !!}
                {!! Form::select('payment_status',App\Models\Order::PAYMENT_STATUS_LIST, isset($filters['payment_status']) ? $filters['payment_status'] : null, ['class'=>'form-control form-control-sm','placeholder' => 'Payment Status']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('shipping_status') !!}
                {!! Form::select('shipping_status',App\Models\Order::SHIPPING_STATUS_LIST, isset($filters['shipping_status']) ? $filters['shipping_status'] : null, ['class'=>'form-control form-control-sm','placeholder' => 'Shipping Status']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('Per page') !!}
                {!! Form::select('per_page', [10 => 10, 20=>20, 50=>50, 100=>100], isset($filters['per_page']) ? $filters['per_page'] : 20, ['class'=>'form-select form-select-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('Sort by') !!}
                <select name="sort_by" class="form-select form-select-sm">
                    <option value="">Select Column</option>
                    @foreach($columns as $column)
                        <option
                            {{ isset($filters['sort_by'])  ? ($filters['sort_by'] == $column ? 'selected': null) : null }} value="{{$column}}">{{ucwords(str_replace('_', ' ', $column))}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                {!! Form::label('Sort direction') !!}
                {!! Form::select('sort_direction', ['asc' => 'ASC', 'desc'=>'DESC'], isset($filters['sort_direction']) ? $filters['sort_direction'] : 20, ['class'=>'form-select form-select-sm']) !!}
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-grid">
                            <button id="reset_fields" class="btn btn-sm btn-warning" type="reset"><i
                                    class="ri-refresh-line"></i> Reset
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-grid">
                            <button class="btn btn-sm btn-success" type="submit"><i class="ri-search-line"></i> Search </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
