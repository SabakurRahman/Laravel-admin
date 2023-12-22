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
                    <h5 class="text-theme py-3">Assigned Customer Group</h5>
                    @forelse($user?->customerGroups as $customerGroups)
                        <button class="btn btn-success">{{$customerGroups->name}}</button>
                    @empty
                        <p class="text-danger text-center">{{__('No Customer Group Assigned')}}</p>
                    @endforelse
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="text-theme py-3">Assign Customer Group to {{$user->name}}</h5>
                {!! Form::open(['method'=>'put', 'route'=>['user-customer-group.update',$user->id]]) !!}
                @forelse($customerGroup as $key=>$value)
                    <div class="form-check">
                        {!! Form::checkbox('customer_group_id[]', $key, in_array($key,$user_assigned_customerGroup_id_list, true), ['id'=>'customer_group_id_'.$key,'class'=>'form-check-input']) !!}
                        {!! Form::label('customer_group_id_'.$key, $value, ['class'=>'form-check-label','style'=>'margin-top:0!important']) !!}
                    </div>
                @empty
                    <p class="text-danger text-center">{{__('No Customer Group Found')}}</p>
                    <a href="{{route('customer-group.create')}}">
                        <button type="button" class="btn btn-success btn-sm">Please create Customer Group</button>
                    </a>
                @endforelse
                @if(count($customerGroup)>0)
                    {!! Form::button('<i class="ri-refresh-line"></i> Update', ['id'=>'customer_group_update_button','class'=>'btn btn-success mt-3 btn-sm', 'type'=>'submit']) !!}
                @endif
                {!! Form::close([]) !!}
            </div>
        </div>
    </div>
</div>




