@extends('frontend.layouts.master')
@section('content')
        @include('estimation_leads.partials.search')

        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    {{-- <th scope="col">Status</th> --}}
                    <th scope="col"style="padding-left:30px;">Action</th>                  
                </tr>
            </thead>
            <tbody>
                @forelse ($estimationLeads  as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->name}}</td>
                        <td>{{ $item->phone}}</td>
                        <td>{{ $item->email}}</td>
     
                        <td>
                            <div class="d-flex">
                                <a style="margin-right:10px!important"href="{{ route('estimation-lead.show',$item->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                {{-- <a href="{{ route('estimation-lead.edit',$item->id) }}">
                                    <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                                </a> --}}
                                {!!Form::open(['route'=> ['estimation-lead.destroy', $item->id], 'method'=>'delete'])!!}
                                {!!Form::button('<i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
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
        {{$estimationLeads ->links()}}
                    
@endsection
@push('script')
    <script>
        $('#name').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })
    </script>
@endpush
