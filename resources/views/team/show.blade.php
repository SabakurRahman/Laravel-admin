@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}
    <fieldset>
        <legend>Basic Information</legend>
    <table class="table table-striped">
        <tr>
            <th scope="row">Id</th>
            <td>{{$team->id}}</td>
        </tr>
        <tr>
            <th scope="row">Name</th>
            <td>{{$team->name}}</td>
        </tr>
        <tr>
            <th scope="row">Title</th>
            <td>{{$team->title}}</td>
        </tr>
        <tr>
            <th scope="row">Description</th>
            <td>{{strip_tags($team->description)}}</td>
        </tr>
        <tr>
            <th scope="row">Status</th>
            <td>{{ \App\Models\FaqPage::STATUS_LIST[$team->status]}}</td>
        </tr>
        <tr>
            <th scope="row">Created at</th>
            <td>{{$team->created_at->format('D, M j, Y g:i A')}} </td>
        </tr>
        <tr>
            <th scope="row">Updated at</th>
            <td>
                {{ $team->created_at != $team->updated_at ? $team->updated_at->format('D, M j, Y g:i A') : 'Not updated' }}
            </td>

        </tr>
        <tr>
            <th scope="row">Photo</th>
            <td> <img src="{{asset(\App\Models\Team::PHOTO_UPLOAD_PATH. $team['photo'])}}" width="75px">
        </tr>

    </table>
    </fieldset>
    @include('global_partials.activity_log', ['activity_logs'=> $team?->activity_logs])

@endsection


