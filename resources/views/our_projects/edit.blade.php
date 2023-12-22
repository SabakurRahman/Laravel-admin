@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($ourproject, ['route'=>['our-project.update',$ourproject->id], 'method'=>'put']) !!}
            @include('our_projects.form')
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="d-grid">
                        {!! Form::button('Update Project Information', ['class' => 'btn btn-outline-theme mt-4', 'type'=>'submit']) !!}
                    </div>
                </div>
            </div>
            {{-- {!! Form::button('Update Project!', ['class' => 'btn btn-success mt-4', 'type'=>'submit']) !!} --}}
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



{{-- Date:31/08/2023
Aabash
Complete:
1.Sotorupa testing
2.Project module(project list,project add,update)
3.project  module search design --}}

