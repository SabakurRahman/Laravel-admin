@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}

    <fieldset>
        <legend>Basic Information</legend>
        <table class="table table-striped">
            <tr>
                <th scope="row">Id</th>
                <td>{{$ourApproach->id}}</td>
            </tr>
            <tr>
                <th scope="row">name</th>
                <td>{{$ourApproach->name}}</td>
            </tr>
            <tr>
                <th scope="row">Description</th>
                <td>{{ strip_tags( $ourApproach->description)}}</td>
            </tr>
            <tr>
                <th scope="row">serial</th>
                <td>{{$ourApproach->serial}}</td>
            </tr>


            <tr>
                <th scope="row">Status</th>
                <td>{{ \App\Models\OurApproach::STATUS_LIST[$ourApproach->status]}}</td>
            </tr>    <tr>
                <th scope="row">Banner</th>
                <td><img src="{{asset( App\Models\OurApproach::BANNER_UPLOAD_PATH.$ourApproach['banner'])}}" width="50px"></td>
            </tr>
            <tr>
                <th scope="row">Created at</th>
                <td>{{$ourApproach->created_at->format('D, M j, Y g:i A')}} </td>
            </tr>
            <tr>
                <th scope="row">Updated at</th>
                <td>
                    {{ $ourApproach->created_at != $ourApproach->updated_at ? $ourApproach->updated_at->format('D, M j, Y g:i A') : 'Not updated' }}
                </td>

            </tr>
        </table>
    </fieldset>
    @include('global_partials.activity_log', ['activity_logs'=> $ourApproach?->activity_logs])
@endsection


