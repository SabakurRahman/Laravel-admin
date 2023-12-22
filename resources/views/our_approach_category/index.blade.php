@extends('frontend.layouts.master')
@section('content')
    @include('our_approach_category.partials.search')

    <table class="table table-striped">
        <thead>
        <tr>
            <th>SL</th>
            <th>name</th>
            <th>Description</th>
            <th>status</th>
            <th>serial</th>
            <th>photo</th>
            <th>created at</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ourApproachCategory as $list)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$list->name}}</td>
                <td>{{ Str::limit(strip_tags( $list->description),30)}}</td>
                <td>{{ \App\Models\OurApproachCategory::STATUS_LIST[$list->status]}}</td>
                <td>{{$list->serial}}</td>
                <td> <img src="{{asset( App\Models\OurApproachCategory::PHOTO_UPLOAD_PATH.$list['photo'])}}" width="50px"></td>
                <td>{{$list?->created_at?->toDayDateTimeString()}}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('our-approach-category.show',$list->id) }}">
                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                        </a>
                        <a href="{{ route('our-approach-category.edit',$list->id) }}">
                            <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                        </a>
                        {!!Form::open(['route'=> ['our-approach-category.destroy',  $list->id], 'method'=>'delete'])!!}
                        {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                        {!!Form::close()!!}
                    </div>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

@endsection


