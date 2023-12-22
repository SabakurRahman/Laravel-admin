@extends('frontend.layouts.master')
@section('content')
        @include('blog_category.partials.search')

    <table class="table table-striped">
        <thead>
        <tr>
            <th>SL</th>
            <th>name</th>
            <th>slug</th>
            <th>photo</th>
            <th>status</th>
            <th >cover photo</th>
            <th>type</th>
            <th>created by</th>
            <th>created at</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($blogCategoryList as $list)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$list->name}}</td>
                <td>{{ $list->slug}}</td>
                <td> <img src="{{asset(\App\Models\BlogCategory::PHOTO_UPLOAD_PATH. $list['photo'])}}" width="50px">
                <td>{{ \App\Models\BlogCategory::STATUS_LIST[$list->status]}}</td>
                <td> <img src="{{asset(\App\Models\BlogCategory::COVER_PHOTO_UPLOAD_PATH. $list['cover_photo'])}}" width="50px">
                <td>{{ \App\Models\BlogCategory::TYPE_LIST[$list->type]}}</td>
                <td>{{$list?->user?->name}}</td>
                <td>{{$list?->created_at?->toDayDateTimeString()}}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('blog-category.show',$list->id) }}">
                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                        </a>
                        <a href="{{ route('blog-category.edit',$list->id) }}">
                            <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                        </a>
                        {!!Form::open(['route'=> ['blog-category.destroy',  $list->id], 'method'=>'delete'])!!}
                        {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                        {!!Form::close()!!}
                    </div>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

@endsection


