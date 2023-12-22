@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}

    <fieldset>
        <legend>Basic Information</legend>
        <table class="table table-striped">
            <tr>
                <th scope="row">Id</th>
                <td>{{$ourApproachCategory->id}}</td>
            </tr>
            <tr>
                <th scope="row">name</th>
                <td>{{$ourApproachCategory->name}}</td>
            </tr>
            <tr>
                <th scope="row">slug</th>
                <td>{{$ourApproachCategory->slug}}</td>
            </tr>
            <tr>
                <th scope="row">serial</th>
                <td>{{$ourApproachCategory->serial}}</td>
            </tr>

            <tr>
                <th scope="row">Status</th>
                <td>{{ \App\Models\OurApproachCategory::STATUS_LIST[$ourApproachCategory->status]}}</td>
            </tr>
            <tr>
                <th scope="row">Created at</th>
                <td>{{$ourApproachCategory->created_at->format('D, M j, Y g:i A')}} </td>
            </tr>
            <tr>
                <th scope="row">Updated at</th>
                <td>
                    {{ $ourApproachCategory->created_at != $ourApproachCategory->updated_at ? $ourApproachCategory->updated_at->format('D, M j, Y g:i A') : 'Not updated' }}
                </td>

            </tr>
        </table>
    </fieldset>
    @include('global_partials.activity_log', ['activity_logs'=> $ourApproachCategory?->activity_logs])
@endsection


