@extends('frontend.layouts.master')
@section('content')
        @include('role.partials.search')

        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Role Name</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col" style="padding-left:30px;">Action</th>
                </tr>
            </thead>
                <!-- end thead -->
            <tbody>
                @forelse($roles as $role)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        
                        <td>{{$role->name}}</td>
                        <td>{{$role->created_at->toDayDateTimeString()}}</td>
                        <td>{{$role->updated_at->toDayDateTimeString()}}</td>
                        
                        <td>
                            <div class="d-flex">
                                  <a href="{{ route('role.show',$role->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{ route('role.edit',$role->id) }}">
                                    <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!!Form::open(['route'=> ['role.destroy', $role->id], 'method'=>'delete'])!!}
                                {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                                {!!Form::close()!!}
                                
                            </div>                
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12">
                            <p class="text-center text-danger">{{ __('No Data found') }}</p>
                        </td>
                    </tr>
                @endforelse

             </tbody>
        </table>
        {{$roles->links()}}
     
@endsection

