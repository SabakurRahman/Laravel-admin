
@extends('frontend.layouts.master')
@section('content')
    {{-- @include('global_partials.flash') --}}
    @include('unitPrice.partials.search')

    {{--    @include('global_partials.validation_error_display')--}}

    <table class="table table-striped">
        <thead class="table-topbar">
            <tr>
                <th scope="col">Id</th>
                <th scope="col"class="text-center">Type</th>
                <th scope="col"class="text-center">Category</th>
                <th scope="col"class="text-center">Sub Category</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($unitPriceLists as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td class="text-center">{{ app\Models\UnitPrice::TYPE_LIST[$item->type] ?? 'Unknown Type' }}</td>
                    <td class="text-center">{{ $item->estimateCategory?->name}}</td>
                    <td class="text-center">{{ $item->estimateSubCategory?->name }}</td>
                    {{-- <td>{{ $item->package?->name }}</td> --}}
                    {{-- <td>{{ $item->unit?->name}}</td> --}}
                    
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('unit-price.show',$item->id) }}">
                                <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                            </a>
                            <a href="{{ route('unit-price.edit',$item->id) }}">
                                <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                            </a>
                            {!! Form::open(['route'=> ['unit-price.destroy', $item->id], 'method'=>'delete'])!!}
                            {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                            {!! Form::close()!!}
                                
                        </div>                  
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12">>
                        <p class="text-center text-danger">{{ __('No Data found') }}</p>
                    </td>
                </tr>
            @endforelse
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



