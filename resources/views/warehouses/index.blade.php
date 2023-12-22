@extends('frontend.layouts.master')
@section('content')
        @include('warehouses.partials.search')

        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th style="text-align:center" scope="col">Name</th>
                    <th style="text-align:center" scope="col">Admin Comment</th> 
                    <th style="text-align:center" scope="col">Phone</th>
                    <th style="text-align:center" scope="col">City</th>
                    <th style="text-align:center"scope="col">Street Address</th>
                    <th style="text-align:center" scope="col">Status</th>
                    <th scope="col" style="padding-left:30px;">Action</th>

                </tr>
            </thead>
            <tbody>
                @forelse($warehouses as $warehouse)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td style="text-align:center"> {{$warehouse->name}}</td>
                        <td style="text-align:center"> {{$warehouse->admin_comment}}</td>
                        <td style="text-align:center"> {{$warehouse->phone}}</td>
                        <td style="text-align:center"> {{$warehouse->city}}</td>
                        <td style="text-align:center"> {{$warehouse->street_address}}</td>
                        <td style="text-align:center">{{ \App\Models\Warehouse::STATUS_LIST[$warehouse->status]}}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('warehouses.show',$warehouse->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{ route('warehouses.edit',$warehouse->id) }}">
                                <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!!Form::open(['route'=> ['warehouses.destroy', $warehouse->id], 'method'=>'delete'])!!}
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
        {{$warehouses->links()}}
  
@endsection

