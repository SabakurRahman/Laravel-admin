@extends('frontend.layouts.master')
@section('content')
    @include('product.partials.search')
    
    <table class="table table-striped">
        <thead class="table-topbar">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">SKU</th>
                <th scope="col">Model</th>
                <th scope="col">Product Type</th>
                <th scope="col">Created on</th>
                <th scope="col"style="padding-left:30px">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$product->title}}</td>
                    <td>{{$product->slug}}</td>
                    <td>{{$product->sku}}</td>
                    <td>{{$product->model}}</td>
                    <td>{{$product->product_type ==1 ? 'Simple' :'Grouped by variation' }}</td>
                    <td>{{$product->created_at->toDayDateTimeString()}}</td>
                        {{-- <td style="width:150px">{{$product->created_at->toDayDateTimeString()}}</td> --}}        
                    <td>
                        <div class="d-flex">
                            <a style="margin-right:5px;" href="{{ route('product.show',$product->id) }}">
                                <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                            </a>
                             <a style="margin-right:5px;"href="{{ route('product.edit',$product->id) }}">
                                <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                            </a>
                            {!!Form::open(['route'=> ['product.destroy', $product->id], 'method'=>'delete'])!!}
                            {!!Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
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
    {{$products->links()}}
   
@endsection