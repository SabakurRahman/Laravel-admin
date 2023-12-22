@extends('frontend.layouts.master')
@section('content')
    @include('customer_group.customerGroupUserAssociation.partials.search')
    <div class="row">
        <div class="col-md-12">
            <table id="categoryTable"
                   class="table table-striped">
                <thead class="table-topbar text-lowercase">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th style="text-align:center">Email</th>
                    <th style="text-align:center">Phone</th>
                    <th style="text-align:center">User Group</th>
                    <th>Register Time</th>
                    <th style="text-align:center">Action</th>
                    {{-- <th style="width: 120px;">Action</th> --}}
                </tr>
                </thead>
                <!-- end thead -->
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td style="text-align: -webkit-center;">
                            @forelse($user?->customerGroups as $customerGroup)
                                <button class="m-1 btn btn-sm btn-success">{{ $customerGroup->name }}</button>
                            @empty
                                <p class="text-danger">No Customer Group assigned</p>
                            @endforelse
                        </td>
                        <td>{{ $user->created_at->toDayDateTimeString() }}</td>
                        <td>
                            <a style="text-align: -webkit-center;"href="{{ route('user-customer-group-edit',$user->id) }}">
                                <button class="btn btn-sm btn-secondary"><i class="ri-edit-box-line"></i></button>
                            </a>
                            {{-- <a href="{{ route('user.edit', $user->id) }}">
                                <button class="btn btn-sm btn-theme">Assign/Update Role</button>
                            </a> --}}
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
        </div>
        {{ $users->links() }}
    </div>
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





