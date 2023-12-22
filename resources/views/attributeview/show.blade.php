@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}

    <fieldset>
        <legend>Basic Information</legend>
        <table class="table table-striped">
            <tr>
                <th scope="row">Id</th>
                <td>{{$attribute->id}}</td>
            </tr>
            <tr>
                <th scope="row">name</th>
                <td>{{$attribute->name}}</td>
            </tr>
            <tr>
                <th scope="row">name bn</th>
                <td>{{$attribute->name_bn}}</td>
            </tr>
            <tr>
                <th scope="row">Description</th>
                <td>{{ strip_tags( $attribute->description)}}</td>
            </tr>    <tr>
                <th scope="row">Description</th>
                <td>{{ strip_tags( $attribute->description_bn)}}</td>
            </tr>



            <tr>
                <th scope="row">Status</th>
                <td>{{ \App\Models\Attribute::STATUS_LIST[$attribute->status]}}</td>
            </tr>    <tr>
                <th scope="row">Photo</th>
                <td><img src="{{asset( App\Models\Attribute::PHOTO_UPLOAD_PATH.$attribute['photo'])}}" width="50px"></td>
            </tr>
            <tr>
                <th scope="row">Created at</th>
                <td>{{$attribute->created_at->toDayDateTimeString()}} </td>
            </tr>
            <tr>
                <th scope="row">Updated at</th>
                <td>
                {{$attribute?->created_at == $attribute?->updated_at ? 'Not updated' : $attribute?->updated_at?->toDayDateTimeString()}}
                </td>

            </tr>
        </table>
    </fieldset>
    @include('global_partials.activity_log', ['activity_logs'=> $attribute?->activity_logs])
@endsection


