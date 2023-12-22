@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}

    <table class="table table-striped">
        <tr>
            <th scope="row">Id</th>
            <td>{{$blogPost->id}}</td>
        </tr>
        <tr>
            <th scope="row">Title</th>
            <td>{{$blogPost->title}}</td>
        </tr>
        <tr>
            <th scope="row">Slug</th>
            <td>{{$blogPost->slug}}</td>
        </tr>
        <tr>
            <th scope="row">Description</th>
            <td>{!! $blogPost->description !!}</td>
        </tr>
        <tr>
            <th scope="row">Status</th>
            <td>{{ \App\Models\BlogPost::STATUS_LIST[$blogPost->status]}}</td>
        </tr>
        <tr>
            <th scope="row">Photos</th>
            <td>
                <div class="row">
                    @foreach ($blogPost->blogPhoto as $photo)
                        <div class="col-md-2">
                            <div class="card mb-4">
                                <img style="max-width: 100% ; height: auto" src="{{ asset(\App\Models\BlogPost::PHOTO_UPLOAD_PATH . $photo->photo) }}" width="75px" class="card-img-top" alt="Blog Photo">
                            </div>
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>

        <th scope="row">Video</th>
            <td>{{$blogPost->video_url}}</td>
            <iframe width="400" height="215" src="{{ $blogPost->video_url }}" frameborder="0" allowfullscreen></iframe>


        </tr>




        <tr>
            <th scope="row">Blog Category</th>
            <td>{{$blogPost->blog_category?->name}}</td>
        </tr>
        <tr>
            <th scope="row">Blog Type</th>
            <td>{{App\Models\BlogPost::BLOG_TYPE[$blogPost->type] }}</td>
        </tr>




    </table>

    <h3>Comments</h3>
    <ul class="list-group">
        @foreach($blogPost->blog_comments as $comment)
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-10">
                        <p>{{ $comment->comment }}</p>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex">
                            <div class="media-right ml-auto"> <!-- Use ml-auto class for margin-left:auto -->
                                {!! Form::open(['route'=> ['blog-comment.destroy',  $comment->id], 'method'=>'delete']) !!}
                                {!! Form::button('<i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm float-right delete-button btn-danger']) !!}
                                {!! Form::close() !!}
                            </div>
                            @if($comment->status == \App\Models\BlogComment::STATUS_INACTIVE)
                                <a href="{{ route('comment-status', ['id' => $comment->id, 'status' => \App\Models\BlogComment::STATUS_ACTIVE]) }}"
                                   class="btn btn-sm btn-success">Activate</a>
                            @else
                                <!-- Change status to Inactive -->
                                <a href="{{ route('comment-status', ['id' => $comment->id, 'status' => \App\Models\BlogComment::STATUS_INACTIVE]) }}"
                                   class="btn btn-sm btn-warning">Deactivate</a>
                            @endif
                        </div>
                    </div>
                </div>

                @if($comment->replies->count() > 0)
                    <ul class="list-group mt-3">
                        @foreach($comment->replies as $reply)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-10">
                                        <p>{{ $reply->comment }}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-flex">
                                            <div class="media-right ml-auto"> <!-- Use ml-auto class for margin-left:auto -->
                                                {!! Form::open(['route'=> ['blog-comment.destroy',  $reply->id], 'method'=>'delete']) !!}
                                                {!! Form::button('<i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm float-right delete-button btn-danger p-2']) !!}
                                                {!! Form::close() !!}
                                            </div>
                                            @if($reply->status == \App\Models\BlogComment::STATUS_INACTIVE)
                                                <a href="{{ route('comment-status', ['id' => $reply->id, 'status' => \App\Models\BlogComment::STATUS_ACTIVE]) }}"
                                                   class="btn btn-sm btn-success">Activate</a>
                                            @else
                                                <!-- Change status to Inactive -->
                                                <a href="{{ route('comment-status', ['id' => $reply->id, 'status' => \App\Models\BlogComment::STATUS_INACTIVE]) }}"
                                                   class="btn btn-sm btn-warning">Deactivate</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>

@endsection


