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
                        <td>{{$manufacture->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$manufacture->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Photo</th>
                        <td>
                            <img src="{{asset(\App\Models\Manufacture::PHOTO_UPLOAD_PATH. $manufacture->photo)}}" width="100px"height='100px'>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>{{$manufacture->description}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\Manufacture::STATUS_LIST[$manufacture->status]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($manufacture->created_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($manufacture->updated_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                </table>
            </fieldset>
        </div>
        @include('global_partials.activity_log', ['activity_logs'=> $manufacture?->activity_logs])
    </div>

@endsection


