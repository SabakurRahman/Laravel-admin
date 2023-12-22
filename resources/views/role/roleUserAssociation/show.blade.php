@extends('frontend.layouts.master')
@section('content')
    @include('global_partials.validation_error_display')
    <div>
    <fieldset>
        <legend>Details</legend>
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th scope="row">Id</th>
                    <td>{{$user->id}}</td>
                </tr>
                <tr>
                    <th scope="row">Name</th>
                    <td>{{$user->name}}</td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td>{{$user->email}}</td>
                </tr>
                <tr>
                    <th scope="row">Phone</th>
                    <td>{{$user->phone}}</td>
                </tr>
                <tr>
                    <th scope="row">Role</th>
                    <td>    
                        @forelse($user?->roles as $role)
                            <button class="m-1 btn btn-sm btn-success">{{ $role->name }}</button>
                        @empty
                            <p class="text-danger">No role assigned</p>
                        @endforelse
                    </td>
                </tr>
                <tr>
                    <th scope="row">Created At</th>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('j M, Y, D H:i') }}</td>
                </tr>
                <tr>
                    <th scope="row">Updated At</th>
                    <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('j M, Y, D H:i') }}</td>
                </tr>
            </table>
        </fieldset>
    </div>

@endsection


