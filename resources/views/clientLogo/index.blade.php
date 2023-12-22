@extends('frontend.layouts.master')
@section('content')
        {{-- @include('global_partials.flash') --}}
        @include('clientLogo.partials.search')
 
        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th style="text-align:center" scope="col">Title</th>
                    <th style="text-align:center"scope="col">Photo</th>
                    <th style="text-align:center"scope="col">Status</th>
                    {{-- <th  style="text-align:center"scope="col">Created At</th>
                    <th  style="text-align:center"scope="col">Updated At</th> --}}
                    <th scope="col" style="padding-left:30px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientLogos as $logo)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td style="text-align:center"> {{$logo->title}}</td>
                        <td style="text-align:center"> <img src="{{asset(\App\Models\ClientLogo::PHOTO_UPLOAD_PATH. $logo->photo)}}" width="75px">
                        </td>
                        <td style="text-align:center">{{ \App\Models\ClientLogo::STATUS_LIST[$logo->status]}}</td>

                        {{-- <td style="width:150px">{{$logo->created_at->toDayDateTimeString()}}</td>
                        <td style="width:150px">{{$logo->updated_at->toDayDateTimeString()}}</td> --}}
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('client-logo.show',$logo->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{ route('client-logo.edit',$logo->id) }}">
                                    <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!!Form::open(['route'=> ['client-logo.destroy', $logo->id], 'method'=>'delete'])!!}
                                {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                                {!!Form::close()!!}
                            </div> 
                        </td>

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
        {{$clientLogos->links()}}
       
@endsection

