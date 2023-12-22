@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Serial</th>
                                            <th>Parent Category</th>
                                            <th>Photo</th>
                                         
                                        </tr>
                                    </thead>
                                   <tbody>
        @foreach ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['description'] }}</td>
            <td>{{ App\Models\EstimateCategory::STATUS_LIST[$item['status']] }}</td>
            <td>{{ $item['serial'] }}</td>
            <td>{{$item->parentCategory?->name}}</td>
            <td> <img src="{{asset(App\Models\EstimateCategory::PHOTO_UPLOAD_PATH.$item['photo'])}}" width="50px">
            </td>

            <td><a href="{{ route('estimate-category.edit', $item['id']) }}"><i class="fas fa-edit"></i></a></td>
            <td>
                <form class="border-none" action="{{ route('estimate-category.destroy', $item['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@push('script')
    <script>
        $('#name').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })
    </script>
@endpush
