@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}

    <fieldset>
        <legend>Basic Information</legend>
    <table class="table table-striped">
        <tr>
            <th scope="row">Id</th>
            <td>{{$vendor->id}}</td>
        </tr>
        <tr>
            <th scope="row">Name</th>
            <td>{{$vendor->name}}</td>
        </tr>
        <tr>
            <th scope="row">Name BN</th>
            <td>{{$vendor->name_bn}}</td>
        </tr>
        <tr>
            <th scope="row">Slug</th>
            <td>{{$vendor->slug}}</td>
        </tr>
        <tr>
            <th scope="row">Description</th>
            <td>{{strip_tags($vendor->description)}}</td>
        </tr>
        <tr>
            <th scope="row">Description BN</th>
            <td>{{strip_tags($vendor->description_bn)}}</td>
        </tr>
        <tr>
            <th scope="row">Email</th>
            <td>{{$vendor->email}}</td>
        </tr>
        <tr>
            <th scope="row">Serial</th>
            <td>{{$vendor->serial}}</td>
        </tr>
        <tr>
            <th scope="row">Status</th>
            <td>{{ \App\Models\Vendor::STATUS_LIST[$vendor->status]}}</td>
        </tr>
        <tr>
            <th scope="row">Created at</th>
            <td>{{$vendor->created_at->format('D, M j, Y g:i A')}} </td>
        </tr>
        <tr>
            <th scope="row">Updated at</th>
            <td>
                {{ $vendor->created_at != $vendor->updated_at ? $vendor->updated_at->format('D, M j, Y g:i A') : 'Not updated' }}
            </td>

        </tr>
        <tr>
            <th scope="row">Photo</th>
            <td> <img src="{{asset(\App\Models\Vendor::PHOTO_UPLOAD_PATH.$vendor['photo'])}}" width="75px">
        </tr>
    </table>
    </fieldset>
    @include('global_partials.activity_log', ['activity_logs'=> $vendor?->activity_logs])
@endsection


