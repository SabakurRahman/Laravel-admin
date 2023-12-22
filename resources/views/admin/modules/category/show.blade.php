@extends('frontend.layouts.master')
@section('content')
    @include('global_partials.validation_error_display')
    <div class="row">
        <div class="col-md-6">
            <fieldset class="h-100">
                <legend>Basic Information</legend>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th scope="row">Id</th>
                        <td>{{$category->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$category->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Slug</th>
                        <td>{{$category->slug}}</td>
                    </tr>
                    @if($category->category_id !== null)
                        <tr>
                            <th scope="row">Category Name</th>
                            <td>{{$category->parentCategory->name}}</td>
                        </tr>
                    @endif
                    <tr>
                        <th scope="row">Description</th>
                        <td>{{$category->description}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Serial</th>
                        <td>{{$category->serial}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Photo</th>
                        <td>
                            {{-- {{$category->photo}} --}}
                            <img src="{{asset(\App\Models\Category::PHOTO_UPLOAD_PATH. $category->photo)}}" width="100px"height="100px">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Banner</th>
                        <td>
                            {{-- {{$category->banner}} --}}
                            <img src="{{asset(\App\Models\Category::BANNER_UPLOAD_PATH. $category->banner)}}" width="100px"height="100px">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\Category::STATUS_LIST[$category->status]??null}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($category->created_at)->format('D, j M, Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($category->updated_at)->format('D, j M, Y, H:i') }}</td>
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
                        <td>{{$category?->seos?->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Title</th>
                        <td>{{$category->seos?->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Title BN</th>
                        <td>{{$category?->seos?->title_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Keywords</th>
                        <td>{{$category->seos?->keywords}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Keywords BN</th>
                        <td>{{$category?->seos?->keywords_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>{{$category->seos?->description}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description BN</th>
                        <td>{{$category?->seos?->description_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">OG</th>
                        <td>
                            <img
                                class="img-thumbnail"
                                alt="photo"
                                src="{{asset(!empty($category?->seos?->og_image) ? \App\Models\Seo::Seo_PHOTO_UPLOAD_PATH. $category?->seos?->og_image: 'uploads/default.webp')}}"
                                width="75px">
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
            @include('global_partials.activity_log', ['activity_logs'=> $category?->activity_logs])
    </div>
@endsection


