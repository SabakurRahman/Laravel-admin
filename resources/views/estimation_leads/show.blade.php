@extends('frontend.layouts.master')
@section('content')
    @include('global_partials.validation_error_display')
    <div class="row">
        <div>
            <fieldset>
                <legend>User Information</legend>
                <table style="margin-top:20px" class="table table-striped table-hover table-bordered">

                    <tr>
                        <th scope="row">Id</th>
                        <td>{{$estimationLead->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$estimationLead->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Phone</th>
                        <td>{{$estimationLead->phone}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>{{$estimationLead->email}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{\App\Models\EstimationLead::STATUS_LIST[$estimationLead->status] ?? null}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ $estimationLead->created_at->toDayDateTimeString() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ $estimationLead->created_at != $estimationLead->updated_at ? $estimationLead->updated_at->toDayDateTimeString(): 'Not updated yet' }}</td>
                    </tr>
                </table>
            </fieldset>
            @if(!empty($estimationLead->response))
            <fieldset class="mt-4">
                <legend>Lead Information</legend>
                    @foreach(json_decode($estimationLead->response) as $response)
                    <div class="row mb-4">
                        @foreach($response as $key=>$value)
                                @if(!is_object($value))
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <p><span class="text-capitalize">{{$key}}</span> : <strong class="text-success">{{$value}}</strong></p>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-4">
                                        <fieldset>
                                            <legend>{{$key}}</legend>
                                            <table class="table table-striped table-hover mt-4">
                                                @foreach($value as $v_key=>$v_value)
                                                    <tr>
                                                        <th><span class="text-capitalize">{{str_replace('_', ' ',$v_key)}}</span></th>
                                                        <td>{{$v_value}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>

                                        </fieldset>
                                    </div>

                                @endif

                        @endforeach
                    </div>
                    @endforeach
            </fieldset>
            @endif
        </div>
    </div>
@endsection






