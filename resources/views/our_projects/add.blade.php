@extends('frontend.layouts.master')
@section('content')
       @include('global_partials.validation_error_display')

    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'our-project.store', 'method' => 'post' ,'files'=>true]) !!}
                @include('our_projects.form')
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="d-grid">
                        {!! Form::button('Create Our Project Page', ['class' => 'btn btn-outline-theme mt-4', 'type'=>'submit']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>        
    </div>
@endsection
@push('script')
    <script>
        $('#name').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })
    </script>
@endpush
