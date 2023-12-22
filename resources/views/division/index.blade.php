@extends('frontend.layouts.master')
@section('content')
{{--    @include('blog.partials.search')--}}
    <table class="table table-striped">
        <thead>
        <tr>
            <th>SL</th>
            <th>name</th>
            <th>name_bn</th>
            <th>status</th>

            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($division as $list)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$list->name}}</td>
                <td>{{$list->name_bn}}</td>
                <td>{{ \App\Models\Division::STATUS_LIST[$list->status] ?? null}}</td>
                <td>
                    <div class="d-flex">

                        <a href="{{ route('division.edit',$list->id) }}">
                            <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                        </a>
                    {!!Form::open(['route'=> ['division.destroy',  $list->id], 'method'=>'delete'])!!}
                    {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                    {!!Form::close()!!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$division->links()}}

@endsection


