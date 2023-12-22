@extends('frontend.layouts.master')
@section('content')
    {{-- @include('global_partials.flash') --}}
    @include('unit.partials.search')

    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Short Name</th>
                <th scope="col">Status</th>
                <th scope="col">Created At</th>
                <th scope="col">Updated At</th>
                <th scope="col" style="padding-left:30px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($unitLists as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$item->name}}</td>
                    <td>{{$item->short_name}}</td>
                    <td>{{ \App\Models\Unit::STATUS_LIST[$item->status]}}</td>
                    <td>{{$item->created_at->toDayDateTimeString()}}</td>
                    <td>{{$item->updated_at->toDayDateTimeString()}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('unit.show',$item->id) }}">
                                <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                            </a>
                            <a href="{{ route('unit.edit',$item->id) }}">
                                <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                            </a>
                            {!!Form::open(['route'=> ['unit.destroy', $item->id], 'method'=>'delete'])!!}
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
    {{$unitLists->links()}}
                        
@endsection
@push('script')
    <script>
        $('#name').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })

    </script>
@endpush
