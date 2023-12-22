@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($approachCategory, ['route'=>['our-approach-category.update', $approachCategory->id], 'method'=>'put' ,'files'=>true ]) !!}
            @include('our_approach_category.form')
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="d-grid">
                        {!! Form::button('Update Our Approach  ', ['class' => 'btn btn-outline-theme mt-4', 'type'=>'submit']) !!}
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
