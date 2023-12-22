@extends('frontend.layouts.master')
@section('content')
       @include('global_partials.validation_error_display')
    <div class="row">
        <div>
            <fieldset>
                <legend>Detais</legend>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th scope="row">Id</th>
                        <td>{{$warehouse->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$warehouse->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Admin Comment</th>
                        <td>{{$warehouse->admin_comment}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Phone</th>
                        <td>{{$warehouse->phone}}</td>
                    </tr>
                    <tr>
                        <th scope="row">City</th>
                        <td>{{$warehouse->city}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Street Address</th>
                        <td>{{$warehouse->street_address}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\Warehouse::STATUS_LIST[$warehouse->status]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($warehouse->created_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($warehouse->updated_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                </table>
            </fieldset>
        </div>
            @include('global_partials.activity_log', ['activity_logs'=> $warehouse?->activity_logs])
    </div>

@endsection


