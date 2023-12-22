@extends('frontend.layouts.master')
@section('content')
    @include('our_approach.partials.search')

    <table class="table table-striped">
        <thead>
        <tr>

            <th>SL</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Serial</th>
            <th>Category</th>
            <th>Image</th>
            <th>Created At</th>
            <th>Action</th>

        </tr>

        </thead>
        <tbody>
        @foreach($ourApproach as $list)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$list->name}}</td>
                <td>{{ Str::limit(strip_tags( $list->description),30)}}</td>
                <td>{{ \App\Models\OurApproach::STATUS_LIST[$list->status]}}</td>
                <td>{{$list->serial}}</td>
                <td>{{ $list->ourApproachCategory->name }}</td>
                <td> <img src="{{asset( App\Models\OurApproach::BANNER_UPLOAD_PATH.$list['banner'])}}" width="50px"></td>
                <td>{{$list?->created_at?->toDayDateTimeString()}}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('our-approach.show',$list->id) }}">
                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                        </a>
                        <a href="{{ route('our-approach.edit',$list->id) }}">
                            <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                        </a>
                        {!!Form::open(['route'=> ['our-approach.destroy',  $list->id], 'method'=>'delete'])!!}
                        {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                        {!!Form::close()!!}
                    </div>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@push('script')
    <script>
        $('#name').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })
    </script>
@endpush







