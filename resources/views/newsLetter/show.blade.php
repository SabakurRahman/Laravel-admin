@extends('frontend.layouts.master')
@section('content')
       @include('global_partials.validation_error_display')
    <div class="row">
        <div>
            <fieldset>
                <legend>Details</legend>
                <table class="table table-striped-hover table-bordered">
                    <tr>
                        <th scope="row">Id</th>
                        <td>{{$newsLetter->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$newsLetter->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>{{$newsLetter->email}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Ip</th>
                        <td>{{$newsLetter->ip}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\NewsLetter::STATUS_LIST[$newsLetter->status]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($newsLetter->created_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($newsLetter->updated_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                </table>
            
            </fieldset>
        </div>
        @include('global_partials.activity_log', ['activity_logs'=> $newsLetter?->activity_logs])
    </div>

@endsection


