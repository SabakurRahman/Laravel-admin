@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}
    <div class="row">
        <div>
            <fieldset>
                <legend>Details</legend>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th scope="row">Id</th>
                        <td>{{$tag->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">name</th>
                        <td>{{$tag->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\Tag::STATUS_LIST[$tag->status]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created at</th>
                        <td>{{ \Carbon\Carbon::parse($tag->created_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated at</th>
                        <td>{{ \Carbon\Carbon::parse($tag->updated_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                </table>
            </fieldset>
        </div>
        @include('global_partials.activity_log', ['activity_logs'=> $tag?->activity_logs])
    </div>
@endsection


