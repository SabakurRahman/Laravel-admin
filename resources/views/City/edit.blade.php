@extends('frontend.layouts.master')
@section('content')
    @include('global_partials.validation_error_display')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($city, ['route'=>['city.update', $city->id], 'method'=>'put']) !!}
            @include('city.form')
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="d-grid">
                        {!! Form::button('Update City ', ['class' => 'btn btn-outline-theme mt-4', 'type'=>'submit']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

