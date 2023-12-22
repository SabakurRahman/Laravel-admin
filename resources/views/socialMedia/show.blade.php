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
                        <td>{{$social->id}}</td>
                    </tr>
                
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$social->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Photo</th>
                        <td><img src="{{asset(\App\Models\SocialMedia::PHOTO_UPLOAD_PATH.$social->photo)}}" width="100px"height="100px"></td>
                    </tr>
                    <tr>
                        <th scope="row">Url</th>
                        <td>{{$social->url}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\SocialMedia::STATUS_LIST[$social->status]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($social->created_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($social->updated_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                </table>
            </fieldset>
        </div>
            @include('global_partials.activity_log', ['activity_logs'=> $social?->activity_logs])
    </div>

@endsection


