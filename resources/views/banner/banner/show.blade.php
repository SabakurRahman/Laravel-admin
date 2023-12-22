@extends('frontend.layouts.master')
@section('content')
    @include('global_partials.validation_error_display')
    <div class="row">
        <div class="col-md-6">
            <fieldset class="h-100">
                <legend>Basic Information</legend>
                <table class="table table-striped">
                    <tr>
                        <th scope="row">Id</th>
                        <td>{{$banner->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$banner->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Serial</th>
                        <td>{{$banner->serial}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Location</th>
                        <td> 
                            @if ($banner->bannerSize)
                                {{ $banner->bannerSize->location }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Type</th>
                        <td>{{ \App\Models\Banner::TYPE_LIST[$banner->type]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Banner Size</th>
                        <td>
                            @if ($banner->bannerSize)
                                height: {{ $banner->bannerSize->height }}<br>
                                width:{{ $banner->bannerSize->width }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\Banner::STATUS_LIST[$banner->status]}}</td>
                    </tr>
     
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($banner->created_at)->format('D, j M, Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($banner->updated_at)->format('D, j M, Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Banner Photo</th>
                        <td>
                            <img src="{{asset(App\Models\Banner::PHOTO_UPLOAD_PATH. $banner->photo)}}" width="75px" height="75px">
                        </td>
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
                        <td>{{$banner?->seos?->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Title</th>
                        <td>{{$banner->seos?->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Title BN</th>
                        <td>{{$banner?->seos?->title_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Keywords</th>
                        <td>{{$banner->seos?->keywords}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Keywords BN</th>
                        <td>{{$banner?->seos?->keywords_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>{{$banner->seos?->description}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description BN</th>
                        <td>{{$banner?->seos?->description_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">OG</th>
                        <td>
                            <img
                                class="img-thumbnail"
                                alt="photo"
                                src="{{asset(!empty($banner?->seos?->og_image) ? \App\Models\Seo::Seo_PHOTO_UPLOAD_PATH. $banner?->seos?->og_image: 'uploads/default.webp')}}"
                                width="75px">
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
            @include('global_partials.activity_log', ['activity_logs'=> $banner?->activity_logs])
    </div>

@endsection


