
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
                        <td>{{$photo_gallery->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$photo_gallery->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Photo</th>
                        <td><img src="{{asset(\App\Models\PhotoGallerie::PHOTO_UPLOAD_PATH. $photo_gallery->photo)}}" width="100px" height="100px"></td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\PhotoGallerie::STATUS_LIST[$photo_gallery->status]??null}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Shown on slider</th>
                        <td>{{ \App\Models\PhotoGallerie::SLIDER_LIST[$photo_gallery->is_shown_on_slider]??null}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($photo_gallery->created_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($photo_gallery->updated_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                </table>
        
            </fieldset>
        </div>
        @include('global_partials.activity_log', ['activity_logs'=> $photo_gallery?->activity_logs])
    </div>

@endsection


