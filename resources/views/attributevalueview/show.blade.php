@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}

    <fieldset>
        <legend>Basic Information</legend>
        <table class="table table-striped">
            <tr>
                <th scope="row">Id</th>
                <td>{{$attributeValue->id}}</td>
            </tr>
            <tr>
                <th scope="row">name</th>
                <td>{{$attributeValue->name}}</td>
            </tr>
            <tr>
                <th scope="row">name bn</th>
                <td>{{$attributeValue->name_bn}}</td>
            </tr>
            <tr>
                <th scope="row">Display Order</th>
                <td>{{$attributeValue->display_order}}</td>
            </tr>
            <tr>
                <th scope="row">Attribute</th>
                <td>{{$attributeValue->attribute->name}}</td>
            </tr>


            <tr>
                <th scope="row">Status</th>
                <td>{{ \App\Models\AttributeValue::STATUS_LIST[$attributeValue->status]}}</td>
            </tr>
            <tr>
                <th scope="row">Created at</th>
                <td>{{$attributeValue->created_at->toDayDateTimeString()}} </td>
            </tr>
            <tr>
                <th scope="row">Updated at</th>
                <td>
                    {{$attributeValue?->created_at == $attributeValue?->updated_at ? 'Not updated' : $attributeValue?->updated_at?->toDayDateTimeString()}}
                </td>

            </tr>
        </table>
    </fieldset>
    @include('global_partials.activity_log', ['activity_logs'=> $attributeValue?->activity_logs])
@endsection


