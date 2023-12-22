@extends('frontend.layouts.master')
@section('content')
    @include('global_partials.validation_error_display')

    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route'=>'blog-comment.store', 'method'=>'post']) !!}
            @include('blog_comment.form')
            {!! Form::button('Create Blog Comment', ['class' => 'btn btn-success mt-4', 'type'=>'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

