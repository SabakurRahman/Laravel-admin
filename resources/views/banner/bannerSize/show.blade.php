@extends('frontend.layouts.master')
@section('content')
       @include('global_partials.validation_error_display')
    <div class="row">
        <div>
            <fieldset>
                <legend>Details</legend>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th scope="row">Id</th>
                        <td>{{$bannerSize->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Banner Name</th>
                        <td>{{$bannerSize->banner_name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Width</th>
                        <td>{{$bannerSize->width}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Height</th>
                        <td>{{$bannerSize->height}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Location</th>
                        <td>{{$bannerSize->location}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($bannerSize->created_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($bannerSize->updated_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\BannerSize::STATUS_LIST[$bannerSize->status]}}</td>
                    </tr>
                </table>
            </fieldset>
        </div>
        @include('global_partials.activity_log', ['activity_logs'=> $bannerSize?->activity_logs])
    </div>

@endsection


