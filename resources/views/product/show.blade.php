@php
    use App\Models\ProductPhoto;
@endphp
<style>
    
    .productDetails tr>th{
       font-weight: 500!important;
       font-size: 13px!important;
    }

    td{
        font-size: 13px!important;
        font-weight: 450!important;
    }
    .card-head h4{
        padding:10px 0 10px 15px;
        background:rgba(0, 0, 0, 0.05);
        font-size: 20px!important;
        color: black;
        opacity: .75;
    }
    .linkedButton{
        padding:0.09rem 0.5rem !important;
        border-radius:4px!important;
        margin-top:4px;
    }

    .related-product-info {
        display: flex;
        align-items: center;
        
    }

    .related-product-info p {
        font-size: 16px;
    }

    .related-product-info img {
        max-width: 100px;
        height: auto;
    }
</style>


@extends('frontend.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
 
                <div class="row">
                    {{-- Basic Information --}}
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-head"><h4 class="card-title">Basic Information</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-striped table-bordered">
                                        <tbody class="productDetails">
                                            <tr>
                                                <th>ID</th>
                                                <td>{{$product->id}}</td>
                                            </tr>        
                                            <tr>
                                                <th >Title</th>
                                                <td>{{$product->title}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Slug</th>
                                                <td>{{$product->slug}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Model</th>
                                                <td>{{$product->model}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Product Type</th>
                                                <td>{{$product->product_type == 1 ? 'Simple':'Group With Varient'}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Is Published</th>
                                                <td>{{$product->is_published == 1 ?'Pending':($product->is_published == 2 ?'Published':'Not Published')}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Is Show On Home Page</th>
                                                <td>{{$product->is_show_on_home_page == 1 ? 'Yes':'NO'}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Is Allow Review</th>
                                                <td>{{$product->is_allow_review == 1 ? 'Allow':'Not allow'}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Is new</th>
                                                <td>{{$product->is_new == 1 ? 'Yes':'No'}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Is Prime</th>
                                                <td>{{$product->is_prime == 1 ?'Prime':'Not Prime'}}</td>
                                            </tr>

                                             <tr>
                                                <th scope="row">Sort Order</th>
                                                <td>{{$product->sort_order}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Short Description</th>
                                                <td>{{$product->short_description}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Comment</th>
                                                <td>{{$product->comment}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Country Id</th>
                                                <td>{{$product->country?->name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Manufacture Id</th>
                                                <td>{{$product->manufacture?->name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Vendor Id</th>
                                                <td>{{$product->vendor?->name}}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">SEO</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered">
                                        <tr>
                                            <th scope="row">Id</th>
                                            <td>{{$product?->seos?->id}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Title</th>
                                            <td>{{$product->seos?->title}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Title BN</th>
                                            <td>{{$product?->seos?->title_bn}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Keywords</th>
                                            <td>{{$product->seos?->keywords}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Keywords BN</th>
                                            <td>{{$product?->seos?->keywords_bn}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Description</th>
                                            <td>{{$product->seos?->description}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Description BN</th>
                                            <td>{{$product?->seos?->description_bn}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">OG</th>
                                            <td>
                                                <img class="img-thumbnail" alt="photo" src="{{asset(!empty($product?->seos?->og_image) ? \App\Models\Seo::Seo_PHOTO_UPLOAD_PATH. $product?->seos?->og_image: 'uploads/default.webp')}}"="75px">
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div> 
                    </div>

                    <div class="col-lg-6">
                        {{-- Price Information--}}
                        <div class="card">
                            <div class="card-head"><h4 class="card-title">Price Information</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-striped table-bordered">
                                        <tbody class="productDetails">
                                            <tr>
                                                <th scope="row" >Price</th>
                                                <td>{{$product->product_price?->price}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Cost</th>
                                                <td>{{$product->product_price?->cost}}</td>
                                            </tr> 
                                            <tr>
                                                <th scope="row">Discount Type</th>
                                                <td>{{$product->product_price?->discount_type == 0?'Manual':($product->product_price?->discount_type == 1 ? 'Auto' : 'None')}}</td>
                                            </tr>     
                                            <tr>
                                                <th scope="row">Discount Info</th>
                                                <td>{{$product->product_price?->discount_info}}</td>
                                            </tr>  
                                            <tr>
                                                <th scope="row">Old Price</th>
                                                <td>{{$product->product_price?->old_price}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Discount Fixed</th>
                                                <td>{{$product->product_price?->discount_fixed}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Discount Percent</th>
                                                <td>{{$product->product_price?->discount_percent}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Discount Start</th>
                                                <td>{{ \Carbon\Carbon::parse($product->product_price?->discount_start)->format('j M, Y, D H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Discount End</th>
                                                <td>{{ \Carbon\Carbon::parse($product->product_price?->discount_end)->format('j M, Y, D H:i') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- Inventory Information --}}
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">Inventory Information</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-striped table-bordered">
                                        <tbody class="productDetails">
                                            <tr>
                                                <th scope="row">Stock</th>
                                                <td>{{$product->inventories?->stock}}</td>
                                            </tr>        
                                            <tr>
                                                <th scope="row">Max Cart Quantity</th>
                                                <td>{{$product->inventories?->max_cart_quantity}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Min Cart Quantity</th>
                                                <td>{{$product->inventories?->min_cart_quantity}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Available Date</th>
                                                <td>{{ \Carbon\Carbon::parse($product->inventories?->available_date)->format('D, j M, Y, H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Inventory Method</th>
                                                <td>{{$product->inventories?->inventory_method == 1 ? 'Track Inventory':'Do Not Track Inventory'}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Is Available For Pre Order</th>
                                                <td>{{$product->inventories?->is_available_for_pre_order == 1 ? 'Available':'Not Available'}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Is Enable Call for Price</th>
                                                <td>{{$product->inventories?->is_enable_call_for_price == 1 ? 'Enabled':'Not Enabled'}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Is Returnable</th>
                                                <td>{{$product->inventories?->is_returnable == 1 ? 'Returnable':'Not Returnable'}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Disable Buy Button</th>
                                                <td>{{$product->inventories?->disable_buy_button == 1 ? 'Disable':'Not Disable'}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Is Disable Wishlist Button</th>
                                                <td>{{$product->inventories?->is_disable_wishlist_button == 1 ? 'Disable':'Not Disable'}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="row">Low Stock Alert</th>
                                                <td>{{$product->inventories?->low_stock_alert == 1 ? 'Disable':'Enable'}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                        {{-- Linked Date --}}
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">Linked Data</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-striped table-bordered">
                                        <tbody class="productDetails">
                                            <tr>
                                                <th scope="row">Category</th>
                                                <td>
                                                    @foreach ( $product->categories as $category)
                                                        <a class="btn btn-success linkedButton">{{ $category->name }}</a>
                                                     @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" >Accepted Payment Method</th>
                                                <td>
                                                    @foreach ( $product->paymentMethods as $pay)
                                                        <a class="btn btn-success linkedButton">{{ $pay->name }}</a>
                                                    @endforeach
                                                </td>
                                            </tr> 
                                            <tr>
                                                <th scope="row">Warehouse</th>
                                                 <td>
                                                    @foreach ( $product->warehouses as $warehouse)
                                                        <a class="btn btn-success linkedButton">{{ $warehouse->name }}</a>  
                                                    @endforeach
                                                </td>
                                            </tr>   
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Main Photos --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">Product Main Photos</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                          <tbody class="productDetails">
                                            <tr>
                                                <td>
                                                    @foreach ( $product->ProductPhotoWithoutVariation as $ProductPhoto)
                                                         <img style="height:150px;width:150px; margin-right:30px;border:4px solid rgba(0, 0, 0, 0.05);" src="{{ asset(ProductPhoto::PHOTO_UPLOAD_PATH  . $ProductPhoto->photo) }}" >
                                                    @endforeach
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Product Variation Photos --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">Product Variation Photos</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                          <tbody class="productDetails">
                                            <tr>
                                                <td>
                                                    @foreach ( $product->ProductPhotoWithtVariation as $data)
                                                         <img style="height:150px;width:150px; margin-right:30px;border:4px solid rgba(0, 0, 0, 0.05);" src="{{ asset(ProductPhoto::PHOTO_UPLOAD_PATH  . $data->photo) }}" >
                                                    @endforeach
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Variant Product --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">Varient Product</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered ">
                                        <thead class="table-topbar">
                                            <tr>
                                                <th scope="col">SL</th>
                                                <th style="text-align: center" scope="col">Photo</th>
                                                <th style="text-align: center"scope="col">Attributes</th>
                                                <th style="text-align: center"scope="col">Price</th>
                                                <th style="text-align: center"scope="col">Stock</th>
                                            </tr>
                                        </thead>
                                        @foreach ( $product->productVariations as $data)
                                            <tbody class="productDetails">
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                         <td style="text-align: center">
                                                            @foreach($data->productPhotos as $photo)
                                                                <img style="height: 100px; width: 100px; margin-right: 30px; border: 4px solid rgba(0, 0, 0, 0.05);" src="{{ asset(\App\Models\ProductPhoto::PHOTO_UPLOAD_PATH . $photo->photo) }}">
                                                            @endforeach
                                                        </td>
                                                        <td style="text-align: center">
                                                            @foreach($data->variationAttributes as $attri)
                                                                <a class="btn btn-success linkedButton">{{$attri->AttributeName->name }} : {{ $attri->value }}</a>
                                                             @endforeach
                                                        </td>
                                                        
                                                        <td style="text-align: center">{{ $data->price}}</td>     
                                                        <td style="text-align: center">{{ $data->stock }}</td>                       
                                                    </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Related Products --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">Related Products</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <tbody class="productDetails">
                                            <tr>
                                                <td >
                                                    @foreach ($product->relatedProducts as $relatedProduct)
                                                        <div class="related-product">
                                                            <div style="border:2px solid rgba(0, 0, 0, 0.05);padding:5px" class="related-product-info">
                                                                
                                                                @php
                                                                    $firstPhoto = $relatedProduct->ProductPhotos->first();
                                                                @endphp
                                                                @if ($firstPhoto)
                                                                    <img style="height:60px;width:60px; margin-right:10px;border:3px solid rgba(0, 0, 0, 0.05);"src="{{ asset(ProductPhoto::PHOTO_UPLOAD_PATH . $firstPhoto->photo) }}" alt="{{ $firstPhoto->alt_text }}">
                                                                @endif
                                                                <p>{{ $relatedProduct->title }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Description --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">Product Description</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <tbody class="productDetails">
                                             <tr>
                                                <td>{!! $product->description !!}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Faq & Related Product --}}
                <div class="row">
                    {{-- Product Faq --}}
                    <div class="col-lg-6">
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">Product FAQ</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered ">
                                        <thead class="table-topbar">
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Question</th>
                                                <th scope="col">Answer</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        @foreach ( $product->faqs as $faq)
                                            <tbody class="productDetails">
                                                <tr>
                                                    <td>{{$faq->id}}</td>
                                                    <td>{{$faq->question_title}}</td>
                                                    <td>{{$faq->description}}</td>
                                                    <td>{{$faq->status == 1? "Active" : "Inactive"}}</td>                            
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Related Products --}}
                    <div class="col-lg-6">
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">Product Specification </h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered ">
                                        <thead class="table-topbar">
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">value</th>
                                            </tr>
                                        </thead>
                                        @foreach ( $product->specifications as $data)
                                            <tbody class="productDetails">
                                                <tr>
                                                    <td>{{$data->id}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>{{$data->value}}</td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Product Specification & Product Warrenty  --}}
                <div class="row">
                    {{-- Product Shipping Information --}}
                    <div class="col-lg-6 ">
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">Product Shipping details </h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered ">
                                        <tbody class="productDetails">
                                            <tr>
                                                <th scope="col">Id</th>
                                                <td>{{$product->shipping?->id}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="col">Package Weight</th>
                                                <td>{{$product->shipping?->package_weight}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="col">Height</th>
                                                <td>{{$product->shipping?->height}}</td>
                                            </tr>
                                             <tr>
                                               <th scope="col">Width</th>
                                               <td>{{$product->shipping?->width}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="col">Length</th>
                                                <td>{{$product->shipping?->length}}</td>
                                            </tr>
                                             <tr>
                                                <th scope="col">Product type</th>
                                                <td>{{$product->shipping?->product_type == 1? 'Residential Interior':($shippingInfo->product_type == 2? 'commercial Interior':($shippingInfo->product_type == 3? 'Furniture':'Custom Lights'))}}</td>
                                            </tr>

                                            {{-- <tr>
                                                <td>{{$shippingInfo->id}}</td>
                                                <td>{{$shippingInfo->package_weight}}</td>
                                                <td>{{$shippingInfo->id}}</td>
                                                <td>{{$shippingInfo->width}}</td>
                                                <td>{{$shippingInfo->length}}</td>
                                                <td>{{$shippingInfo->product_type == 1? 'Residential Interior':($shippingInfo->product_type == 2? 'commercial Interior':($shippingInfo->product_type == 3? 'Furniture':'Custom Lights'))}}</td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Products Warrenty --}}
                     <div class="col-lg-6">
                        <div class="mt-4 card">
                            <div class="card-head"><h4 class="card-title">Products Warrenty</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered ">
                                        <tbody class="productDetails">
                                              <tr>
                                                <th scope="col">Id</th>
                                                <td>{{$product->warrenty?->id}}</td>
                                            </tr>
                                              <tr>
                                                <th scope="col">Warrenty Type</th>
                                                <td>{{$product->warrenty?->warrenty_type == 1 ? 'Expressed' : 'Implied'}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Warrenty Period</th>
                                                <td>{{$product->warrenty?->warrenty_period == 1 ? '3 month' :($warrentyInfo->warrenty_period == 2 ? '6 month' :'1 year') }}</td>
                                            </tr>
                                              <tr>
                                                <th scope="col">Warrenty Policy</th>
                                                <td>{{$product->warrenty?->warrenty_policy}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                
        </div>
    </div>
@endsection