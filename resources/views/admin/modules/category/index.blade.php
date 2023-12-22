@extends('frontend.layouts.master')
@section('content')
        {{-- @include('global_partials.flash') --}}
        @include('admin.modules.category.partials.search')
    
        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col" style="text-align:center">Slug</th> 
                    <th scope="col" style="text-align:center">Photo</th>
                    <th scope="col" style="text-align:center">Banner</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Status</th>
                    {{-- <th scope="col">Created At</th>
                    <th scope="col">Updated At</th> --}}
                    <th scope="col" style="padding-left:30px;">Action</th>
                </tr>
            </thead>
                <!-- end thead -->
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        {{-- <td>{{$category->serial}}</td> --}}
                        <th scope="row">{{ $loop->iteration }}</th>
                        {{-- <td> {{$category->name}}</td> --}}
                        <td>
                            @if($category->category_id == null)
                                {{$category->name}}

                            @else
                            {{ $category->parentCategory->name }} >> {{ $category->name }}
                                {{-- {{$category->name}} << {{$category->parentCategory->name }} --}}
                            @endif
                        </td>
                        <td>{{$category->slug}}</td>
                        <td> <img src="{{asset(\App\Models\Category::PHOTO_UPLOAD_PATH. $category->photo)}}" width="75px">
                        </td>
                        <td> <img src="{{asset(\App\Models\Category::BANNER_UPLOAD_PATH. $category->banner)}}" width="75px">
                        </td>
                        <td style="text-align:center;">{{$category->serial}}</td>
                        <td>{{ \App\Models\Category::STATUS_LIST[$category->status]??null }}</td>
                        {{-- <td>{{ \App\Models\Category::STATUS_LIST[$category->status]}}</td> --}}
                        
                        {{-- <td style="width:150px">{{$category->created_at->toDayDateTimeString()}}</td>
                        <td style="width:150px">{{$category->updated_at->toDayDateTimeString()}}</td>
                        --}}

                        <td>
                           <div class="d-flex">
                                <a href="{{ route('category.show',$category->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{ route('category.edit',$category->id) }}">
                                    <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!!Form::open(['route'=> ['category.destroy', $category->id], 'method'=>'delete'])!!}
                                {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
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
    {{$categories->links()}}
@endsection

