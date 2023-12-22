@extends('frontend.layouts.master')
@section('content')
        {{-- @include('global_partials.flash') --}}
        @include('estimate_package.partials.search')
        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col" style="padding-left:30px;">Action</th>              
                </tr>
            </thead>
            <tbody>
                @forelse ($estimatePackages as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$item->name}}</td>
                    <td>{{$item->slug}}</td>
                    <td>{{ App\Models\EstimatePackage::STATUS_LIST[$item->status]}}</td>
                    <td>{{$item->created_at->toDayDateTimeString()}}</td>
                    <td>{{$item->updated_at->toDayDateTimeString()}}</td>
                        
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('estimate-package.show',$item->id) }}">
                                <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                            </a>
                            <a href="{{ route('estimate-package.edit',$item->id) }}">
                                <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                            </a>
                            {!!Form::open(['route'=> ['estimate-package.destroy', $item->id], 'method'=>'delete'])!!}
                            {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                            {!!Form::close()!!}
                                
                        </div>                
                    </td>
                    @empty
                    <tr>
                        <td colspan="12">
                            <p class="text-center text-danger">{{ __('No Data found') }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{$estimatePackages->links()}}
                       
@endsection
@push('script')
    <script>
        $('#name').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })
    </script>
@endpush
