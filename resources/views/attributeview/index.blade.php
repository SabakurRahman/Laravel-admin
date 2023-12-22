@extends('frontend.layouts.master')
@section('content')
    @include('attributeview.partials.search')

    <table class="table table-striped">
        <thead>
        <tr>

            <th>SL</th>
            <th>Name</th>
            <th>Name In Bangla</th>
            <th>Description</th>
            <th>Description In Bangla</th>
            <th>Photo</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Action</th>

        </tr>

        </thead>
        <tbody>
        @foreach ($attribute as $list)
            <tr>

                <th>{{ $loop->iteration }}</th>
                <td>{{$list->name}}</td>
                <td>{{$list->name_bn}}</td>
                <td>{{strip_tags($list->description)}}</td>
                <td>{{strip_tags($list->description_bn)}}
                <td> <img src="{{asset( App\Models\Attribute::PHOTO_UPLOAD_PATH.$list->photo)}}" width="50px">
                </td>
                <td> {{App\Models\Attribute::STATUS_LIST[$list->status]}}</td>

                <td>{{ $list->created_at->toDayDateTimeString() }}</td>

                <td>
                    <div class="d-flex">
                        <a href="{{ route('attribute.show',$list->id) }}">
                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                        </a>
                        <a href="{{ route('attribute.edit',$list->id) }}">
                            <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                        </a>
                        {!!Form::open(['route'=> ['attribute.destroy',  $list->id], 'method'=>'delete'])!!}
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








