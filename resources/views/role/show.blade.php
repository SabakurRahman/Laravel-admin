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
                        <td>{{$role->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{$role->name}}</td>
                    </tr>
                    {{-- <tr>
                        <th scope="row">Guard Name</th>
                        <td>{{$role->guard_name}}</td>
                    </tr> --}}
                    <tr>
                        <th scope="row">Created At</th>
                        <td>{{ \Carbon\Carbon::parse($role->created_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($role->updated_at)->format('j M, Y, D H:i') }}</td>
                    </tr>
                </table>
            </fieldset>
        </div>
        @include('global_partials.activity_log', ['activity_logs'=> $role?->activity_logs])
    </div>
@endsection


