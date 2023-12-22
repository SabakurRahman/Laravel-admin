@extends('frontend.layouts.master')

@section('content')
        {{-- @include('global_partials.flash') --}}
        @include('socialMedia.partials.search')


        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col" style="text-align:center">Photo</th>
                    <th scope="col">Url</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col" style="padding-left:30px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($socialMedia as $socialMed)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{$socialMed->name}}</td>
                        <td> <img src="{{asset(\App\Models\SocialMedia::PHOTO_UPLOAD_PATH.$socialMed->photo)}}" width="75px">
                        </td>
                        <td>{{$socialMed->url}}</td>
                        <td>{{ \App\Models\SocialMedia::STATUS_LIST[$socialMed->status]}}</td>
                        <td style="width:150px">{{$socialMed->created_at->toDayDateTimeString()}}</td>
                        <td style="width:150px">{{$socialMed->updated_at->toDayDateTimeString()}}</td>
                        

                        {{-- <td style="width:150px">{{$socialMed->created_at->toDayDateTimeString()}}</td> --}}

                        <td>
                            <div class="d-flex">
                                <a href="{{ route('social.show',$socialMed->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{ route('social.edit',$socialMed->id) }}">
                                    <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!!Form::open(['route'=> ['social.destroy', $socialMed->id], 'method'=>'delete'])!!}
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
        {{$socialMedia->links()}}


@endsection

