@extends('frontend.layouts.master')
@section('content')
        {{-- @include('global_partials.flash') --}}
        @include('paymentMethod.partials.search')
  
        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Account No</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col" style="padding-left:30px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentMethod as $payMethod)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{$payMethod->name}}</td>
                        <td>{{$payMethod->account_no}}</td>
                        <td>{{ \App\Models\PaymentMethod::STATUS_LIST[$payMethod->status]}}</td>
                        
                        <td style="width:150px">{{$payMethod->created_at->toDayDateTimeString()}}</td>
                        <td style="width:150px">{{$payMethod->updated_at->toDayDateTimeString()}}</td>
                        
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('payment-method.show',$payMethod->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{ route('payment-method.edit',$payMethod->id) }}">
                                    <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!!Form::open(['route'=> ['payment-method.destroy', $payMethod->id], 'method'=>'delete'])!!}
                                {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                                {!!Form::close()!!}
                                
                            </div>                
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{$paymentMethod->links()}}
@endsection

