@extends('frontend.layouts.master')
@section('content')
        {{-- @include('global_partials.flash') --}}
        @include('banner.bannerSize.partials.search')
        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Banner Name</th>
                    <th scope="col">Height</th>
                    <th scope="col">Width</th>
                    <th scope="col">Location</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col" style="padding-left:30px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bannerSizes as $bannerSize)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{$bannerSize->banner_name}}</td>
                        <td>{{$bannerSize->height}}</td>
                        <td>{{$bannerSize->width}}</td>
                        <td>{{$bannerSize->location}}</td>
                        <td>{{ \App\Models\BannerSize::STATUS_LIST[$bannerSize->status]}}</td>
                        
                        <td style="width:150px">{{$bannerSize->created_at->toDayDateTimeString()}}</td>
                        <td style="width:150px">{{$bannerSize->updated_at->toDayDateTimeString()}}</td>
                        

                        <td>
                            <div class="d-flex">
                                <a href="{{ route('banner-size.show',$bannerSize->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{ route('banner-size.edit',$bannerSize->id) }}">
                                    <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!!Form::open(['route'=> ['banner-size.destroy', $bannerSize->id], 'method'=>'delete'])!!}
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
        {{$bannerSizes->links()}}
        
@endsection

