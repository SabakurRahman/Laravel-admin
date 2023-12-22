{{-- <style>
    .data-center{
       padding-left:20px!important;
    }
</style> --}}
@extends('frontend.layouts.master')
@section('content')
    {{-- @include('global_partials.flash') --}}
    @include('banner.banner.partials.search')
    
    <table class="table table-striped">
        <thead class="table-topbar">
            <tr>
                <th scope="col">Id</th>
                <th scope="col"style="text-align:center">Image</th>
                <th scope="col"style="text-align:center">Type</th>
                <th scope="col"style="text-align:center">Size</th>
                <th scope="col"style="text-align:center">Location</th>
                <th scope="col"style="text-align:center">Serial</th>
                <th scope="col"style="text-align:center">Status</th>
                <th scope="col"style="text-align:center">Created At</th>
                {{-- <th scope="col"style="text-align:center">Updated At</th> --}}
                <th scope="col"style="text-align:center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banners as $banner)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td style="text-align:center"> <img src="{{asset(App\Models\Banner::PHOTO_UPLOAD_PATH. $banner->photo)}}" width="75px"height="75px">
                    </td>
                    <td style="text-align:center">{{$banner->type ==1 ? "Banner":($banner->type ==2 ? "Slider": "Advertisement") }}</td>

                    <td style="text-align:center">
                        @if ($banner->bannerSize)
                            height: {{ $banner->bannerSize->height }}<br>
                            width:{{ $banner->bannerSize->width }}
                        @endif
                    </td>
                    <td style="text-align:center">
                        @if ($banner->bannerSize)
                            {{ $banner->bannerSize->location }}
                        @endif
                    </td>
                    <td style="text-align:center">{{$banner->serial}}</td>
                    <td>{{ \App\Models\Banner::STATUS_LIST[$banner->status]}}</td>
                        
                    <td style="text-align:center">{{$banner->created_at->toDayDateTimeString()}}</td>
                    {{-- <td style="width:150px">{{$banner->updated_at->toDayDateTimeString()}}</td> --}}
                         
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('banner.show',$banner->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{ route('banner.edit',$banner->id) }}">
                                    <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!!Form::open(['route'=> ['banner.destroy', $banner->id], 'method'=>'delete'])!!}
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
     {{$banners->links()}}
@endsection

