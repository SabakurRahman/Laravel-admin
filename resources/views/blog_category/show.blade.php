@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}
    <div class="row">
        <div class="col-md-6">
            <fieldset class="h-100">
                <legend>Basic Information</legend>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th>Id</th>
                        <td>{{$blogCategory->id}}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{$blogCategory->name}}</td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td>{{$blogCategory->slug}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ \App\Models\BlogCategory::STATUS_LIST[$blogCategory->status] ?? null}}</td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>{{ \App\Models\BlogCategory::TYPE_LIST[$blogCategory->type] ?? null}}</td>
                    </tr>
                    <tr>
                        <th>Created By</th>
                        <td>{{$blogCategory?->user?->name}}</td>
                    </tr>
                    <tr>
                        <th>Created at</th>
                        <td>{{ $blogCategory?->created_at?->toDayDateTimeString()}}</td>
                    </tr>
                    <tr>
                        <th>Updated at</th>
                        <td>{{$blogCategory?->created_at == $blogCategory?->updated_at ? 'Not updated' : $blogCategory?->updated_at?->toDayDateTimeString()}}</td>
                    </tr>
                    <tr>
                        <th>Photo</th>
                        <td><img class="img-thumbnail" alt="photo"
                                 src="{{asset(\App\Models\BlogCategory::PHOTO_UPLOAD_PATH. $blogCategory->photo)}}"
                                 width="75px"></td>
                    </tr>
                    <tr>
                        <th>Cover Photo</th>
                        <td><img class="img-thumbnail" alt="photo"
                                 src="{{asset(\App\Models\BlogCategory::COVER_PHOTO_UPLOAD_PATH. $blogCategory->cover_photo)}}"
                                 width="75px"></td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="h-100">
                <legend>SEO</legend>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th scope="row">Id</th>
                        <td>{{$blogCategory?->seos?->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Title</th>
                        <td>{{$blogCategory->seos?->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Title BN</th>
                        <td>{{$blogCategory?->seos?->title_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Keywords</th>
                        <td>{{$blogCategory->seos?->keywords}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Keywords BN</th>
                        <td>{{$blogCategory?->seos?->keywords_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>{{$blogCategory->seos?->description}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description BN</th>
                        <td>{{$blogCategory?->seos?->description_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">OG</th>
                        <td>
                            <img
                                class="img-thumbnail"
                                alt="photo"
                                src="{{asset(!empty($blogCategory?->seos?->og_image) ? \App\Models\Seo::Seo_PHOTO_UPLOAD_PATH. $blogCategory?->seos?->og_image: 'uploads/default.webp')}}"
                                width="75px">
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
            @include('global_partials.activity_log', ['activity_logs'=> $blogCategory?->activity_logs])
    </div>

@endsection


