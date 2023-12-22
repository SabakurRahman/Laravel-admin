@extends('frontend.layouts.master')
@section('content')
    @include('global_partials.validation_error_display')
    <div class="row">
        <div class="col-md-6">
            <fieldset class="h-100">
                <legend style="padding-bottom:15px!important">Basic Information</legend>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th scope="row">Id</th>
                        <td>{{$EstimateCategory->id}}</td>
                    </tr>

                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$EstimateCategory->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Slug</th>
                        <td>{{$EstimateCategory->slug}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>{{$EstimateCategory->description}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Parent Category</th>
                        <td>
                            @if ($EstimateCategory->parentCategory)
                                {{ $EstimateCategory->parentCategory->name }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Serial</th>
                        <td>{{$EstimateCategory->serial}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Type</th>
                        <td>{{ \App\Models\EstimateCategory::TYPES_LIST[$EstimateCategory->type]??null}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\EstimateCategory::STATUS_LIST[$EstimateCategory->status]??null}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Photo</th>
                        <td class="img-thumbnail">
                             <img  src="{{asset(\App\Models\EstimateCategory::PHOTO_UPLOAD_PATH. $EstimateCategory->photo)}}" width="100px"height="100px">
                            
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Banner</th>
                        <td>
                            <img src="{{asset(\App\Models\EstimateCategory::BANNER_UPLOAD_PATH. $EstimateCategory->banner)}}" width="200px" height="100px">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">created by</th>
                        <td>{{$EstimateCategory->user->name}}</td>
                    </tr>

                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($EstimateCategory->created_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($EstimateCategory->updated_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                
                </table>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="h-100">
                <legend style="padding-bottom:15px!important">SEO</legend>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th scope="row">Id</th>
                        <td>{{$EstimateCategory?->seos?->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Title</th>
                        <td>{{$EstimateCategory->seos?->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Title BN</th>
                        <td>{{$EstimateCategory?->seos?->title_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Keywords</th>
                        <td>{{$EstimateCategory->seos?->keywords}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Keywords BN</th>
                        <td>{{$EstimateCategory?->seos?->keywords_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>{{$EstimateCategory->seos?->description}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description BN</th>
                        <td>{{$EstimateCategory?->seos?->description_bn}}</td>
                    </tr>
                    <tr>
                        <th scope="row">OG</th>
                        <td>
                            <img
                                class="img-thumbnail"
                                alt="photo"
                                src="{{asset(!empty($EstimateCategory?->seos?->og_image) ? \App\Models\Seo::Seo_PHOTO_UPLOAD_PATH. $EstimateCategory?->seos?->og_image: 'uploads/default.webp')}}"
                                width="75px">
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
            @include('global_partials.activity_log', ['activity_logs'=> $EstimateCategory?->activity_logs])
    </div>
@endsection


