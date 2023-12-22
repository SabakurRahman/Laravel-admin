@extends('frontend.layouts.master')
@section('content')
       @include('global_partials.validation_error_display')
    <div class="row">
        <div class="row">
            <div  class="col-md-6">
                <fieldset>
                    <legend>Basic Information</legend>
                    <table style="margin-top:20px"class="table table-striped table-hover table-bordered">

                        <tr>
                            <th scope="row">Id</th>
                            <td>{{$unitPrice->id}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Category</th>
                            <td>{{$unitPrice->estimateCategory?->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Sub Category</th>
                            <td>{{$unitPrice->estimateSubCategory?->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Type</th>
                            <td>{{$unitPrice->type == 1 ? 'Office Interior' : 'Home Interior'}}</td>
                        </tr>
                        {{-- <tr>
                            <th scope="row">Created by</th>
                            <td>{{$unitPrice->user->name}}</td>
                        </tr>
                    --}}
                        <tr>
                            <th scope="row">Created At</th>
                            <td>{{ \Carbon\Carbon::parse($unitPrice->created_at)->format('D, j M, Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Updated At</th>
                            <td>{{ \Carbon\Carbon::parse($unitPrice->updated_at)->format('D, j M, Y, H:i') }}</td>
                        </tr>
                    </table>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset>
                    <legend>Package Information</legend>

                    @foreach ($unitPrice->estimatePrices as $estimatePrice)
                        <fieldset>

                            <legend >{{ $estimatePrice->package->name }}</legend>
                            <table style="margin-top:20px" class="table table-striped table-hover table-bordered">
                                <tr>
                                    <th scope="row">id</th>
                                    <td>{{ $estimatePrice->id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Unit</th>
                                    <td>{{ $estimatePrice?->unit?->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Maximum Size</th>
                                    <td>{{ $estimatePrice?->max_size }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Minimum Size</th>
                                    <td>{{ $estimatePrice?->min_size }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Per Unit Price</th>
                                    <td>{{ $estimatePrice->price }}</td>
                                </tr>
                            </table>
                        </fieldset>
                    @endforeach

                </fieldset>
            </div>
        </div>
        @include('global_partials.activity_log', ['activity_logs' => $unitPrice?->activity_logs?->concat($unitPrice?->estimatePrices?->flatMap?->activity_logs)])
    </div>
    {{-- @include('global_partials.activity_log', ['activity_logs'=> $unitPrice?->activity_logs]) --}}

    {{-- <div class="col-md-12">
        @include('global_partials.activity_log', ['activity_logs' => $unitPrice->activity_logs->concat($unitPrice->estimatePrices->flatMap->activity_logs)])
    </div>
     --}}


@endsection


