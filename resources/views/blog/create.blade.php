@extends('frontend.layouts.master')
@section('content')
    @include('global_partials.validation_error_display')

    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route'=>'blog-post.store', 'method'=>'post','files'=>true]) !!}
            @include('blog.form')
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="d-grid">
                        {!! Form::button('Create Blog Post', ['class' => 'btn btn-outline-theme mt-4', 'type'=>'submit']) !!}
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('#title').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })

        $('#type').on('change', function () {
             if ($(this).val() == 2) {
                 $('.video-input').removeClass('d-none')
             } else {
                 $('.video-input').addClass('d-none')
             }
         })
 
         $(document).ready(function () {
         $('#type').trigger('change');
     });
   
 </script>
@endpush


