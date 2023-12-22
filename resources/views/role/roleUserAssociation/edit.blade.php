@extends('frontend.layouts.master')
@section('content')
       @include('global_partials.validation_error_display')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($user, ['route'=>['user.update', $user->id], 'method'=>'put']) !!}
            @include('role.roleUserAssociation.form')
            {{-- {!! Form::button('Update Role Information', ['class' => 'btn btn-success mt-4', 'type'=>'submit']) !!} --}}
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
