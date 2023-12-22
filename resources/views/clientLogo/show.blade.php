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
                        <td>{{$clientLogo->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$clientLogo->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Photo</th>
                        <td>
                            <img src="{{asset(\App\Models\ClientLogo::PHOTO_UPLOAD_PATH. $clientLogo->photo)}}" width="100px" height="100px">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\ClientLogo::STATUS_LIST[$clientLogo->status]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($clientLogo->created_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($clientLogo->updated_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                </table>
            </fieldset>
        </div>
        @include('global_partials.activity_log', ['activity_logs'=> $clientLogo?->activity_logs])
    </div>


@endsection


