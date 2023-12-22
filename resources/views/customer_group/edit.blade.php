@extends('frontend.layouts.master')
@section('content')
    @include('global_partials.validation_error_display')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($customerGroup, ['route'=>['customer-group.update', $customerGroup->id], 'method'=>'put']) !!}
            @include('customer_group.form')
            {!! Form::button('Update Customer Group ', ['class' => 'btn btn-success mt-4', 'type'=>'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
