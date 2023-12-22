@extends('frontend.layouts.master')
@section('content')
    @include('blog.partials.search')
    <table class="table table-striped">
        <thead>
        <tr>
            <th>SL</th>
            <th>title</th>
            <th>slug</th>
            <th>status</th>
            <th>type</th>
            <th>Category</th>
            <th>Author</th>
            <th>Date Time</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($blogPostList as $list)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$list->title}}</td>
                <td>{{$list->slug}}</td>
                <td>{{ \App\Models\BlogPost::STATUS_LIST[$list->status] ?? null}}</td>
                <td>{{ \App\Models\BlogPost::BLOG_TYPE[$list->type] ?? null }}</td>
                <td>{{$list?->blog_category?->name}}</td>
                <td>{{$list?->user?->name}}</td>
                <td>{{$list?->created_at?->toDayDateTimeString()}}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('blog-post.show',$list->id) }}">
                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                        </a>
                        <a href="{{ route('blog-post.edit',$list->id) }}">
                            <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                        </a>
                    {!!Form::open(['route'=> ['blog-post.destroy',  $list->id], 'method'=>'delete'])!!}
                    {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                    {!!Form::close()!!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $blogPostList->links() }}

@endsection


