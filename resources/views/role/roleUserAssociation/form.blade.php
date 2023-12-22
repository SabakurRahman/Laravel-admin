<style>
    .userCheckboxStyle label {
        margin-top: 0!important;
    }
</style>
<fieldset>
    <legend Style="margin-bottom:5px!important">Role Association Information</legend>
     <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <td>{{$user->name}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$user->email}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{$user->phone}}</td>
                            </tr>
                        </thead>
                    </table>
                    <div class="roles">
                        <h5 class="text-theme py-3">Assigned Role</h5>
                        @forelse($user?->roles as $role)
                            <button class="btn btn-success">{{$role->name}}</button>
                        @empty
                            <p class="text-danger text-center">{{__('No Role Assigned')}}</p>
                        @endforelse
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="text-theme py-3">Assign Role to {{$user->name}}</h5>
                    {!! Form::open(['method'=>'put', 'route'=>['user.update', $user->id]]) !!}
                        @forelse($roles as $key=>$value)
                            <div class="form-check userCheckboxStyle">
                                {!! Form::checkbox('role_id[]', $key, in_array($key, $user_assigned_role_id_list, true), ['id'=>'role_id_'.$key,'class'=>'form-check-input']) !!}
                                {!! Form::label('role_id_'.$key, $value, ['class'=>'form-check-label']) !!}
                            </div>
                        @empty
                            <p class="text-danger text-center">{{__('No Role Found')}}</p>
                            <a href="{{route('role.create')}}">
                                <button type="button" class="btn btn-success btn-sm">Please create role</button>
                            </a>
                        @endforelse
                        @if(count($roles)>0)
                            {!! Form::button('<i class="ri-refresh-line"></i> Update', ['id'=>'role_update_button','class'=>'btn btn-success mt-3 btn-sm', 'type'=>'submit']) !!}
                        @endif
                    {!! Form::close([]) !!}
                </div>
            </div>
        </div>
    </div>
</fieldset>
        {{-- </div>
    </div> --}}
    {{-- @push('script')
        <script>
            $('#role_update_button').on('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "{{$user->name . 'will be assigned those roles'}}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Assign'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent('form').submit()
                    }
                })
            })
        </script>
    @endpush --}}




