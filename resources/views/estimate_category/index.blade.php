@extends('frontend.layouts.master')
@section('content')
        {{-- @include('global_partials.flash') --}}
        @include('estimate_category.partials.search')

        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Type</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Status</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Banner</th>
                    <th scope="col"style="padding-left:30px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($estimateCategoryLists as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->name}}</td>
                        <td>{{ $item->slug}}</td>
                        <td>{{ App\Models\EstimateCategory::TYPES_LIST[$item->type] }}</td>
                        <td>{{ $item->serial }}</td>
                        <td>{{ App\Models\EstimateCategory::STATUS_LIST[$item->status] }}</td>

                        <td> <img src="{{asset(App\Models\EstimateCategory:: PHOTO_UPLOAD_PATH . $item->photo)}}" width="50px">
                        </td>
                        <td> <img src="{{asset(App\Models\EstimateCategory:: BANNER_UPLOAD_PATH . $item->banner)}}" width="50px">
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('estimate-category.show',$item->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{ route('estimate-category.edit',$item->id) }}">
                                    <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!!Form::open(['route'=> ['estimate-category.destroy', $item->id], 'method'=>'delete'])!!}
                                {!! Form::button('<i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
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
        {{$estimateCategoryLists->links()}}

@endsection
@push('script')
    <script>
        $('#name').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })
    </script>
@endpush
