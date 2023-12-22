@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Comment</th>
            <th scope="col">status</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($blogCommentList as $list)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$list->comment}}</td>
                <td>{{ \App\Models\BlogComment::STATUS_LIST[$list->status]}}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('faq.show',$list->id) }}">
                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                        </a>
                        <a href="{{ route('faq.edit',$list->id) }}">

                            <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                        </a>
                        {!!Form::open(['route'=> ['faq.destroy',  $list->id], 'method'=>'delete'])!!}
                        {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}

                        {!!Form::close()!!}

                    </div>

                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

@endsection


