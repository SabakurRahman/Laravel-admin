@extends('frontend.layouts.master')
@section('content')
        {{-- @include('global_partials.flash') --}}
        @include('manufacture.partials.search')
  
        <table class="table table-striped">
            <thead class="table-topbar ">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col" style="padding-left:30px;">Action</th>

                </tr>
            </thead>
            <tbody>
                @forelse($manufactures  as $manufacture)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td> {{$manufacture->name}}</td>
                        <td> <img src="{{asset(\App\Models\Manufacture::PHOTO_UPLOAD_PATH. $manufacture->photo)}}" width="75px">
                        </td>
                        <td>{{$manufacture->serial}}</td>

                        <td>{{ \App\Models\Manufacture::STATUS_LIST[$manufacture->status]}}</td>

                        <td style="width:150px">{{$manufacture->created_at->toDayDateTimeString()}}</td>
                        <td style="width:150px">{{$manufacture->updated_at->toDayDateTimeString()}}</td>

                        <td>
                          <div class="d-flex">
                            <a href="{{ route('manufacture.show',$manufacture->id) }}">
                                <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                            </a>
                            <a href="{{ route('manufacture.edit',$manufacture->id) }}">
                                <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                            </a>
                            {!!Form::open(['route'=> ['manufacture.destroy', $manufacture->id], 'method'=>'delete'])!!}
                            {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                            {!!Form::close()!!}
                        </div> 

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="12">
                            <p class="text-danger text-center">{{ __('No Data found') }}</p>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        {{$manufactures->links()}}

@endsection

