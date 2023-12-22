@extends('frontend.layouts.master')
@section('content')
  <style>
      .badge-soft-secondary {
          color: #74788d;
          background-color: rgba(116,120,141,.18);
      }
  </style>
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="datatable" class="table table-sm table-bordered dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Courier Name</th>
                            <th>City</th>
                            <th>Zone</th>
                            <th>Inside Dhaka Courier Charge (TK)</th>
                            <th>Outside Dhaka Courier Charge (TK)</th>
                            <th>Inside Dhaka Condition Charge (%)</th>
                            <th>Outside Dhaka Condition Charge (%)</th>
                            <th>Inside Dhaka Return Charge (%)</th>
                            <th>Outside Dhaka Return Charge (%)</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($courier as $courierList)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $courierList->name }}</td>
                            <td>
                                @foreach($courierList?->cities as $cityList  )
                                    <span class="badge badge-soft-secondary">{{$cityList->name}}</span>
                                @endforeach



                            </td>
                            <td>
                                @foreach($courierList?->zones as $zoneList  )
                                <span class="badge badge-soft-secondary">{{$zoneList->name}}</span>
                                @endforeach
                            </td>
                            <td>{{$courierList->inside_courier_charge}}</td>
                            <td>{{$courierList->outside_courier_charge}}</td>
                            <td>{{$courierList->inside_condition_charge}}</td>
                            <td>{{$courierList->outside_condition_charge}}</td>
                            <td>{{$courierList->inside_return_charge}}</td>
                            <td>{{$courierList->outside_return_charge}}</td>
                            <td>
                                @if($courierList->status === \App\Models\Courier::STATUS_ACTIVE)
                                    <span class="badge bg-success"><i class="fas fa-check"></i></span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times"></i></span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('couriers.edit',$courierList->id) }}">

                                        <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                                    </a>
                                    {!!Form::open(['route'=> ['couriers.destroy',  $courierList->id], 'method'=>'delete'])!!}
                                    {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}

                                    {!!Form::close()!!}

                                </div>
                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">

                </div>
            </div>
        </div>
    </div> <!-- end col -->

 {{$courier->links()}}

@endsection





