@extends('frontend.layouts.master')
@section('content')
    {{-- @include('global_partials.flash') --}}
    @include('role.roleUserAssociation.partials.search')

    <table class="table table-striped">
                {{-- <thead class="table-topbar text-lowercase"> --}}
        <thead class="table-topbar">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col"style="text-align:center">Email</th>
                <th scope="col"style="text-align:center">Phone</th>
                <th scope="col"style="text-align:center">Roles</th>
                <th scope="col">Register Time</th>
                <th scope="col">Update Time</th>
                <th scope="col"style="text-align:center">Action</th>
                        {{-- <th style="width: 120px;">Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td style="text-align: -webkit-center;">
                        @forelse($user?->roles as $role)
                            <button class="m-1 btn btn-sm btn-success">{{ $role->name }}</button>
                        @empty
                            <p class="text-danger">No role assigned</p>
                        @endforelse
                    </td>
                    <td style="width:150px">{{ $user->created_at->toDayDateTimeString() }}</td>
                           
                    <td style="width:150px">{{$user->updated_at->toDayDateTimeString()}}</td>
                    <td>
                        <div class="d-flex">
                            <a style="margin-right:5px"href="{{ route('user.show',$user->id) }}">
                                <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                            </a>
                            <a href="{{ route('user.edit',$user->id) }}">
                                <button class="btn btn-sm btn-secondary"><i class="ri-edit-box-line"></i></button>
                            </a>
                        </div> 
                           
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <p class="text-danger text-center">{{ __('No Data found') }}</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
      
    {{ $users->links() }}
    
    @push('script')
        <script>
            $('.role_delete_button').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will be logged out form admin panel",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, logout'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent('form').submit()
                    }
                })
            })
        </script>
    @endpush
@endsection





