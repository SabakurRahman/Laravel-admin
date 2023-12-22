@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($payment_method, ['route'=>['payment-method.update', $payment_method->id], 'method'=>'put']) !!}
            @include('paymentMethod.form')
            {{-- {!! Form::button('Update Payment Method Information', ['class' => 'btn btn-success mt-4', 'type'=>'submit']) !!} --}}
            {{-- {!! Form::button('Update Payment Method Information', ['class' => 'btn btn-success mt-4', 'type'=>'submit']) !!} --}}
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="d-grid">
                        {!! Form::button('Update Payment Method Information', ['class' => 'btn btn-outline-theme mt-4', 'type'=>'submit']) !!}
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
