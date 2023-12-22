@extends('frontend.layouts.master')
@section('content')
        {{-- @include('global_partials.flash') --}}
        @include('project_category.partials.search')
 
        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th style="text-align:center"scope="col">Name</th>
                    <th style="text-align:center"scope="col">Status</th>
                    <th style="text-align:center"scope="col">Serial</th>
                    <th style="text-align:center"scope="col">Photo</th>
                    <th style="text-align:center"scope="col">Banner</th>
                    <th style="text-align:center"scope="col">Created at</th>
                    <th scope="col" style="padding-left:30px;">Action</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($projectCategories as $projectCategory)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td style="text-align:center">{{$projectCategory->name}}</td>
                        <td style="text-align:center"> {{App\Models\ProjectCategory::STATUS_LIST[$projectCategory->status] ?? null}}</td>
                        <td style="text-align:center">{{$projectCategory->serial}}</td>
                        <td style="text-align:center"><img alt="{{$projectCategory->name}}"src="{{asset(app\Models\ProjectCategory::PHOTO_UPLOAD_PATH. $projectCategory->photo)}}"width="75px"> </td>
                        <td style="text-align:center"><img alt="{{$projectCategory->banner}}"src="{{asset(app\Models\ProjectCategory::BANNER__UPLOAD_PATH_THUMB. $projectCategory->banner)}}" width="75px"></td>
                        <td style="text-align:center">{{$projectCategory->created_at->toDayDateTimeString()}}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('project-category.show',$projectCategory->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{route('project-category.edit',$projectCategory->id)}}">
                                    <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!! Form::open(['route'=>['project-category.destroy', $projectCategory->id], 'method'=>'delete']) !!}
                                {!! Form::button('<i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                                {!! Form::close() !!}
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
        {{$projectCategories->links()}}
                    
@endsection
@push('script')
    <script>
        $('#name').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })
    </script>
@endpush
