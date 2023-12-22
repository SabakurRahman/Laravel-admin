<style>
    .cover-photo {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        height:500px;
    }
    @media (min-width: 992px) {
        .carousel-inner .carousel-item {
            display: none;
        }
        .carousel-inner .carousel-item.active,
        .carousel-inner .carousel-item-next,
        .carousel-inner .carousel-item-prev {
            display: block;
        }
        .carousel-inner .carousel-item.active:first-child,
        .carousel-inner .carousel-item-next:first-child,
        .carousel-inner .carousel-item-prev:first-child {
            display: block;
        }
        .carousel-inner .carousel-item.active:last-child,
        .carousel-inner .carousel-item-next:last-child,
        .carousel-inner .carousel-item-prev:last-child {
            display: block;
        }
    }

    /* Medium screens (md) */
    @media (min-width: 768px) and (max-width: 991px) {
        .col-md-3 {
            width: 25%;
        }
    }

    /* Small screens (sm) */
    @media (min-width: 576px) and (max-width: 767px) {
        .col-sm-4 {
            width: 33.33333333%;
        }
    }

    /* Extra-small screens (xs) */
    @media (max-width: 575px) {
        .col-6 {
            width: 50%;
        }
    }
    .legandStyle{
        padding-top:30px!important;
        padding-bottom:10px!important;
    }
</style>
@extends('frontend.layouts.master')
@section('content')
    <div style="margin-bottom:60px!important"class="row">
        {{-- Photo --}}
        <div class="col-md-12">
            <div class="card-body">
                <div class="table-responsive">
                    @if($ourProject->primary_photo)
                        <img class="cover-photo"src="{{asset(app\Models\ProjectPhoto::PHOTO_UPLOAD_PATH.$ourProject->primary_photo['photo'])}}">
                    @endif
                </div>           
            </div>
            <div class="card-body">
                <div id="projectCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($ourProject->photos_all->chunk(6) as $key => $photos)
                            <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                                <div class="row">
                                    @foreach ($photos as $photo)
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                            <img src="{{ asset(app\Models\ProjectPhoto::PHOTO_UPLOAD_PATH . $photo['photo']) }}" class="img-thumbnail" alt="Project Photo" width="200" height="100">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                         @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#projectCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#projectCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>        
            </div>
        </div>

        <div style="display:flex;"class="col-md-12">
            {{-- Project Summery--}}
            <div class="col-md-6">
                <div class="card-body">
                    <div class="table-responsive">
                        <fieldset class="h-100">
                            <legend class="legandStyle">Project Details</legend>
                            <table class="table table-striped table-hover table-bordered">
                                    <tr>
                                        <th scope="row">Id</th>
                                        <td>{{$ourProject->id}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td>{{$ourProject->name}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Slug</th>
                                        <td>{{$ourProject->slug}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Description</th>
                                        <td>{{$ourProject->project_description}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Created At</th>
                                        <td>{{ \Carbon\Carbon::parse($ourProject->created_at)->format('D, j M, Y, H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Updated At</th>
                                        <td>{{ \Carbon\Carbon::parse($ourProject->updated_at)->format('D, j M, Y, H:i') }}</td>
                                    </tr>
                                
                            </table>
                        </fieldset>
                    </div>           
                </div>
            </div>
            {{-- SEO--}}
            <div class="col-md-6">
                <div class="card-body">
                    <div class="table-responsive">
                        <fieldset class="h-100">
                            <legend class="legandStyle">SEO</legend>
                            <table class="table table-striped table-hover table-bordered">
                                <tr>
                                    <th scope="row">Id</th>
                                    <td>{{$ourProject?->seos?->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Title</th>
                                    <td>{{$ourProject->seos?->title}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Title BN</th>
                                    <td>{{$ourProject?->seos?->title_bn}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Keywords</th>
                                    <td>{{$ourProject->seos?->keywords}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Keywords BN</th>
                                    <td>{{$ourProject?->seos?->keywords_bn}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Description</th>
                                    <td>{{$ourProject->seos?->description}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Description BN</th>
                                    <td>{{$ourProject?->seos?->description_bn}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">OG</th>
                                    <td>
                                        <img class="img-thumbnail" alt="photo"
                                            src="{{asset(!empty($ourProject?->seos?->og_image) ? \App\Models\Seo::Seo_PHOTO_UPLOAD_PATH. $ourProject?->seos?->og_image: 'uploads/default.webp')}}"
                                            width="75px">
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                </div>
            </div> 
                            
        </div>
        <div style="display:flex;"class="col-md-12">
            {{-- Project Summery--}}
            <div class="col-md-6">
                <div class="card-body">
                    <div class="table-responsive">
                        <fieldset class="h-100">
                            <legend class="legandStyle">Project Summery</legend>
                            <table class="table table-striped table-bordered mb-0">
                                <tr>
                                    <th scope="row">Project Type</th>
                                    <td>{{$ourProject->type == 1? 'Office Interior': 'Home Interior'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Project Category</th>
                                    <td>{{$ourProject?->project_category?->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Client Name</th>
                                    <td>{{$ourProject->client_name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total Area</th>
                                    <td>{{$ourProject->total_area}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total Cost</th>
                                    <td>{{$ourProject->total_cost}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Project Location</th>
                                    <td>{{$ourProject->project_location}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Show on Home Page</th>
                                    <td>{{$ourProject->is_show_on_home_page == 1?'Yes':'No'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td>{{$ourProject->status == 1?'Active':'Inactive'}}</td>
                                </tr>          
                            </table>
                        </fieldset>
                    </div>           
                </div>
            </div>
            {{-- Tags --}}
            <div class="col-md-6">
                <div class="card-body">
                    <div class="table-responsive">
                        <fieldset class="h-100">
                            <legend class="legandStyle">Project Tags List</legend>
                            <table class="table table-striped table-hover table-bordered">
                                <tr>
                                    <ul style="padding-left:20px">
                                        @foreach ($ourProject->tags as $tag)
                                            <li >{{ $tag->name }}</li>
                                        @endforeach
                                    </ul>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                </div>
            </div> 
                            
        </div>
    </div>

    @include('global_partials.activity_log', ['activity_logs'=> $ourProject?->activity_logs])

@endsection
@push('script')
    <script>
        $('#name').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })

    </script>
@endpush
