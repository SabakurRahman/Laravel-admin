@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}
    @include('vendor.partials.search')
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">name</th>
            <th scope="col">name bn</th>
            <th scope="col">slug</th>
            <th scope="col">photo</th>
            <th scope="col">description</th>
            <th scope="col">description bn</th>
            <th scope="col">status</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($vendorList as $list)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$list->name}}</td>
                <td>{{$list->name_bn}}</td>
                <td>{{ $list->slug}}</td>
                <td> <img src="{{asset(\App\Models\Vendor::PHOTO_UPLOAD_PATH. $list['photo'])}}" width="50px">
                <td>{{ Str::limit(strip_tags($list->description,30))}}</td>
                <td>{{ Str::limit(strip_tags($list->description_bn,30))}}</td>
                <td>{{ \App\Models\Vendor::STATUS_LIST[$list->status]}}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('vendor.show',$list->id) }}">
                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                        </a>
                        <a href="{{ route('vendor.edit',$list->id) }}">

                            <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                        </a>
                        {!!Form::open(['route'=> ['vendor.destroy',  $list->id], 'method'=>'delete'])!!}
                        {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}

                        {!!Form::close()!!}
                    </div>


                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $vendorList->links() }}
@endsection


