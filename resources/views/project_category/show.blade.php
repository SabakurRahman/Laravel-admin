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
                        <td>{{$projectCategory->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$projectCategory->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Slug</th>
                        <td>{{$projectCategory->slug}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Serial</th>
                        <td>{{$projectCategory->serial}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\Tag::STATUS_LIST[$projectCategory->status]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($projectCategory->created_at)->format('M j, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>{{$projectCategory->description}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Photo</th>
                        <td><img alt="{{$projectCategory->name}}"src="{{asset(app\Models\ProjectCategory::PHOTO_UPLOAD_PATH. $projectCategory->photo)}}"width="75px"></td>
                    </tr>
                    <tr>
                        <th scope="row">Banner photo</th>
                        <td><img alt="{{$projectCategory->banner}}"src="{{asset(app\Models\ProjectCategory::BANNER__UPLOAD_PATH_THUMB. $projectCategory->banner)}}"width="75px"></td>
                    </tr>
                </table>
            </fieldset>
        </div>
        @include('global_partials.activity_log', ['activity_logs'=> $projectCategory?->activity_logs])
    </div>

@endsection




