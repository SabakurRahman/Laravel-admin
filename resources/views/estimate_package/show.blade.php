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
                        <td>{{$estimatePackage->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$estimatePackage->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Slug</th>
                        <td>{{$estimatePackage->slug}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{ \App\Models\EstimatePackage::STATUS_LIST[$estimatePackage->status]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($estimatePackage->created_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($estimatePackage->updated_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                </table>
            </fieldset>
        </div>
        @include('global_partials.activity_log', ['activity_logs'=> $estimatePackage?->activity_logs])
    </div>

@endsection


