<style>
    .right {
        float: right;
    }
</style>
@extends('frontend.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
{{--            @include('global_partials.validation_error_display')--}}
            {!! Form::open(['route' => 'unit-price.store', 'method' => 'post' ,'files'=>true]) !!}
            @include('unitPrice.form')
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="d-grid">
                        {!! Form::button('Create Estimate Price Page', ['class' => 'btn btn-outline-theme mt-4', 'type'=>'submit']) !!}
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
    {{-- <script>
        $(document).ready(function () {
            $('#packageTabs a').on('click', function (e) {
               e.preventDefault();
               $(this).tab('show');
            });
        });
    </script> --}}
@endpush



