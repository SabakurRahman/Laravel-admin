@extends('frontend.layouts.master')
@section('content')
        @include('web_content.partials.search')
        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Titla</th>
                    <th scope="col">Location</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col" style="padding-left:30px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($webContents as $webContent)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{$webContent->title}}</td>
                        <td>{{ \App\Models\WebContent::LOCATION_LIST[$webContent->location]}}</td>
<<<<<<< HEAD
                        <td style="width:150px">{{$webContent->created_at->toDayDateTimeString()}}</td>
                        <td style="width:150px">{{$webContent->updated_at->toDayDateTimeString()}}</td>
=======

                        <td style="width:150px">{{$webContent->created_at->toDayDateTimeString()}}</td>
                        <td style="width:150px">{{$webContent->updated_at->toDayDateTimeString()}}</td>


>>>>>>> e112c9eb998b7e8e4ff974168422b416f5080997
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('web-content.show',$webContent->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{ route('web-content.edit',$webContent->id) }}">
                                    <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!!Form::open(['route'=> ['web-content.destroy', $webContent->id], 'method'=>'delete'])!!}
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
        {{$webContents->links()}}

@endsection

