@extends('frontend.layouts.master')
@section('content')
       @include('global_partials.validation_error_display')
    <div class="row">
        <div>
        <fieldset>
            <legend>Basic Information</legend>
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th scope="row">Id</th>
                    <td>{{$webContent->id}}</td>
                </tr>
                <tr>
                    <th scope="row">Title</th>
                    <td>{{$webContent->title}}</td>
                </tr>
                <tr>
                    <th scope="row">location</th>
                    <td>{{ \App\Models\WebContent::LOCATION_LIST[$webContent->location]}}</td>
                </tr>
<<<<<<< HEAD
=======

>>>>>>> e112c9eb998b7e8e4ff974168422b416f5080997
                <tr>
                    <th scope="row">Content</th>
                    <td>{!! $webContent->content !!}</td>
                </tr>

                <tr>
                    <th scope="row">Created At</th>
                    <td>{{ \Carbon\Carbon::parse($webContent->created_at)->format('j M, Y, D H:i') }}</td>
                </tr>
                <tr>
                    <th scope="row">Updated At</th>
                    <td>{{ \Carbon\Carbon::parse($webContent->updated_at)->format('j M, Y, D H:i') }}</td>
                </tr>
            </table>
        </fieldset>
        </div>
        @include('global_partials.activity_log', ['activity_logs'=> $webContent?->activity_logs])
    </div>

@endsection


