@extends('frontend.layouts.master')
@section('content')
    {{-- @include('global_partials.flash') --}}
    @include('photoGallery.partials.search')
 
   
    <table class="table table-striped">
                
        <thead class="table-topbar">
            <tr>
                <th scope="col">Id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Location</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col" style="padding-left:30px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($photoGalleries  as $gallery)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td> {{$gallery->title}}</td>
                    <td> <img src="{{asset(\App\Models\PhotoGallerie::PHOTO_UPLOAD_PATH. $gallery->photo)}}" width="75px">
                    </td>
                    {{-- <td style="padding-left:30px;">{{$gallery->is_shown_on_slider}}</td> --}}
                        
                    <td>{{ \App\Models\PhotoGallerie::STATUS_LIST[$gallery->status]}}</td>
                    <td>{{ \App\Models\PhotoGallerie::SLIDER_LIST[$gallery->is_shown_on_slider]}}</td>
                    {{-- <td style="text-align:center;">{{ $gallery->is_shown_on_slider == 1 ? 'Yes' : 'No' }}</td> --}}

                    <td style="width:150px">{{$gallery->created_at->toDayDateTimeString()}}</td>
                    <td style="width:150px">{{$gallery->updated_at->toDayDateTimeString()}}</td>

                    <td>
                        <div class="d-flex">
                             <a href="{{ route('photo-gallery.show',$gallery->id) }}">
                                <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                            </a>
                            <a href="{{ route('photo-gallery.edit',$gallery->id) }}">
                                <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                            </a>
                            {!!Form::open(['route'=> ['photo-gallery.destroy', $gallery->id], 'method'=>'delete'])!!}
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
    {{$photoGalleries->links()}}
@endsection

