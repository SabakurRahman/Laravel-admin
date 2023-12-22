@extends('frontend.layouts.master')
@section('content')
    @include('global_partials.validation_error_display')

    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route'=>'customer-group.store', 'method'=>'post']) !!}
            @include('customer_group.form')
            {!! Form::button('Create Customer Group', ['class' => 'btn btn-success mt-4', 'type'=>'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

