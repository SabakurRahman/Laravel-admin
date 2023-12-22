@extends('frontend.layouts.master')
@section('content')
    {{-- @include('global_partials.flash') --}}
    @include('our_projects.partials.search')

    <table class="table table-striped">
        <thead class="table-topbar">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Type</th>
                <th scope="col">Location</th>
                <th scope="col">Area</th>
                <th scope="col">Cost</th>
                <th scope="col">status</th>
                <th scope="col">Show on home page</th>
                <th scope="col" style="padding-left:30px;">Action</th>
                                         
            </tr>
        </thead>
        <tbody>
            @foreach ($ourProjects as $item)
                <tr>                    
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$item->name}}</td>
                    <td>{{$item->slug}}</td>
                    <td>{{$item->type == 1 ? "Office Interior" : "Home Interior"}}</td>
                    <td>{{$item->project_location}}</td>
                    <td>{{$item->total_area}}</td>
                    <td>{{$item->total_cost}}</td>
                    <td style="text-align:center">{{$item->status== 1 ? "Active" : "Inactive"}}</td>
                    <td style="text-align:center">{{$item->is_show_on_home_page == 1 ? "Yes" : "NO"  }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('our-project.show',$item->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                            </a>
                            <a href="{{route('our-project.edit',$item->id)}}">
                                <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                            </a>
                            {!! Form::open(['route'=>['our-project.destroy', $item->id], 'method'=>'delete']) !!}
                            {!! Form::button('<i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$ourProjects->links()}}
                        
@endsection
{{-- @push('script')
    <script>
        $('#name').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })

    </script>
@endpush --}}
