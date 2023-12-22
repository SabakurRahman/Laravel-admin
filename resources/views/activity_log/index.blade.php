@extends('frontend.layouts.master')
@section('content')
        @include('activity_log.partials.search')
    <div class="col-md-12 mt-4">
        <fieldset>
            <legend>Activity Log</legend>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Admin</th>
                    <th>Note</th>
                    <th>Client Details</th>
                    <th>Old data</th>
                    <th>New data</th>
                    <th>Date Time</th>
                    <th>View</th>
                </tr>
                </thead>
                @forelse($activity_logs as $activity_log)
                    <tbody>
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$activity_log?->user?->name}}</td>
                        <td>{{$activity_log?->note}}</td>
                        <td  style="max-width: 200px">
                            <p><small><span class="text-success">IP</span>: {{$activity_log?->ip}}</small></p>
                            <p><small><span class="text-success">Method Action</span>: {{$activity_log?->method}}</small></p>
                            <p><small><span class="text-success">Route</span>: {{$activity_log?->route}}</small></p>
                            {{--                                <p><small><span class="text-success">Agent</span>: {{$activity_log?->agent}}</small></p>--}}
                        </td>
                        <td style="max-width: 200px"><code>{{$activity_log?->old_data}}</code></td>
                        <td style="max-width: 200px"><code>{{$activity_log?->new_data}}</code></td>
                        <td>{{$activity_log?->created_at->toDayDatetimeString()}}</td>
                        <td><a href=""><button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button></a> </td>
                    </tr>
                    </tbody>
                @empty
                    <tr>
                        <td colspan="8"> <p class="text-center text-danger">No data found</p></td>
                    </tr>
                @endforelse
            </table>
        </fieldset>
        {{$activity_logs->links()}}
    </div>

@endsection


