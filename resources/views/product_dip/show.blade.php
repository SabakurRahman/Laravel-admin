@extends('layouts.admin-template.main')
@section('title', 'Add Product')
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('partials.flash')
                    @include('partials.validation_error_display')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Basic Information</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped table-hover">
                                        <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <td>{{$product?->id}}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{$product?->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Name BN</th>
                                            <td>{{$product?->name_bn}}</td>
                                        </tr>
                                        <tr>
                                            <th>Slug</th>
                                            <td>{{$product?->slug}}</td>
                                        </tr>
                                        <tr>
                                            <th>Slug BN</th>
                                            <td>{{$product?->slug_bn}}</td>
                                        </tr>
                                        <tr>
                                            <th>SKU</th>
                                            <td>{{$product?->sku}}</td>
                                        </tr>
                                        <tr>
                                            <th>Product Type</th>
                                            <td>{{!empty($product->product_type) ? \App\Models\Product::PRODUCT_TYPE_LIST[$product->product_type] : \App\Models\Product::PRODUCT_TYPE_LIST[\App\Models\Product::PRODUCT_TYPE_SIMPLE]}}</td>
                                        </tr>
                                        <tr>
                                            <th>Product Signal</th>
                                            <td>{{\App\Models\Product::SIGNAL_LIST[$product?->signal] ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Is Published</th>
                                            <td>{{\App\Models\Product::STATUS_LIST[$product?->is_published] ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Is Shown On Home Page</th>
                                            <td>
                                                @if(!empty($product?->is_show_on_home_page))
                                                    {{\App\Models\Product::IS_SHOW_ON_HOME_PAGE_LIST[$product?->is_show_on_home_page] ?? ''}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Is Allow Review</th>
                                            <td>{{\App\Models\Product::REVIEW_LIST[$product?->is_allow_review] ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Is New</th>
                                            <td>{{\App\Models\Product::IS_NEW_LIST[$product?->is_new] ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Is Prime</th>
                                            <td>{{\App\Models\Product::IS_PRIME_LIST[$product?->is_prime] ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Is Tax Included</th>
                                            <td>{{\App\Models\Product::TAX_LIST[$product?->is_tax_included] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Is Tax Exempt</th>
                                            <td>{{\App\Models\Product::TAX_LIST[$product?->is_tax_exempt]??''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Is Telecommunication Service</th>
                                            <td>{{\App\Models\Product::TELECOMMUNICATION_SERVICE_LIST[$product?->is_telecommunications_services]??''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Priority</th>
                                            <td>{{$product?->priority}}</td>
                                        </tr>
                                        <tr>
                                            <th>Sort Order</th>
                                            <td>{{$product?->sort_order}}</td>
                                        </tr>
                                        <tr>
                                            <th>Model</th>
                                            <td>{{$product?->model}}</td>
                                        </tr>
                                        <tr>
                                            <th>GTIN</th>
                                            <td>{{$product?->gtin}}</td>
                                        </tr>
                                        <tr>
                                            <th>MPN</th>
                                            <td>{{$product?->mpn}}</td>
                                        </tr>
                                        <tr>
                                            <th>Country Origin</th>
                                            <td>{{$product?->country?->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Manufacturer</th>
                                            <td>{{$product?->manufacturer?->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Vendor</th>
                                            <td>{{$product?->vendor?->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Created By</th>
                                            <td>{{$product?->created_by?->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated By</th>
                                            <td>{{$product?->updated_by?->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{$product?->created_at?->toDayDateTimeString()}}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated At</th>
                                            <td>{{$product?->created_at== $product?->updated_at ? 'Not updated yet':$product?->updated_at->toDayDateTimeString()}}</td>
                                        </tr>
                                        <tr>
                                            <th>Warehouses</th>
                                            <td>
                                                @if(count($product?->warehouses) > 0)
                                                    @foreach($product?->warehouses as $warehouse)
                                                        <button
                                                            class="btn btn-success btn-sm me-1">{{$warehouse->name}}</button>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h4>SEO Information</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped table-hover table-sm">
                                        <tbody>
                                        <tr>
                                            <th>Title</th>
                                            <td>{{$product?->seo?->title}}</td>
                                        </tr>
                                        <tr>
                                            <th>Title BN</th>
                                            <td>{{$product?->seo?->title_bn}}</td>
                                        </tr>
                                        <tr>
                                            <th>Keywords</th>
                                            <td>{{$product?->seo?->keywords}}</td>
                                        </tr>
                                        <tr>
                                            <th>Keywords BN</th>
                                            <td>{{$product?->seo?->keywords_bn}}</td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td>{{$product?->seo?->description}}</td>
                                        </tr>
                                        <tr>
                                            <th>Description BN</th>
                                            <td>{{$product?->seo?->description_bn}}</td>
                                        </tr>
                                        <tr>
                                            <th>OG image</th>
                                            <td>
                                                @if(!empty($product?->seo?->og_image))
                                                    <img
                                                        src="{{asset(\App\Models\Seo::SEO_PHOTO_PATH_THUMB.$product?->seo?->og_image)}}"
                                                        class="img-thumbnail"/>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Price Information</h4>
                                </div>
                                <div class="card-body px-0">
                                    <table class="table table-bordered table-striped table-hover table-sm">
                                        <tr>
                                            <th>Price</th>
                                            <td>{{$product?->price->price}}Tk</td>
                                        </tr>
                                        <tr>
                                            <th>Old Price</th>
                                            <td>{{$product?->price->old_price}}Tk</td>
                                        </tr>
                                        <tr>
                                            <th>Cost</th>
                                            <td>{{$product?->price->cost}}Tk</td>
                                        </tr>
                                        <tr>
                                            <th>Discount Type</th>
                                            <td>
                                                @if(!empty($product?->price->discount_type))
                                                    {{\App\Models\ProductPrice::DISCOUNT_TYPE_LIST[$product?->price->discount_type] ??''}}
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Discount fixed</th>
                                            <td>{{$product?->price->discount_fixed}}Tk</td>
                                        </tr>
                                        <tr>
                                            <th>Discount Percent</th>
                                            <td>{{$product?->price->discount_percent}}%</td>
                                        </tr>
                                        <tr>
                                            <th>Discount Start</th>
                                            <td>{{!empty($product?->price?->discount_start) ? \Carbon\Carbon::parse($product?->price?->discount_start)->toDayDateTimeString(): null}}</td>
                                        </tr>
                                        <tr>
                                            <th>Discount End</th>
                                            <td>{{!empty($product?->price?->discount_end) ? \Carbon\Carbon::parse($product?->price?->discount_end)->toDayDateTimeString(): null}}</td>
                                        </tr>
                                        <tr>
                                            <th>Discount Info</th>
                                            <th>{{$product?->price->discount_info}}</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h4>Inventory Information</h4>
                                </div>
                                <div class="card-body px-0">
                                    <table class="table table-bordered table-striped table-hover table-sm">
                                        <tr>
                                            <th>Stock</th>
                                            <td>{{$product?->inventory?->stock}}</td>
                                        </tr>
                                        @if(!empty($product?->inventory?->available_date))
                                            <tr>
                                                <th>Available Date</th>
                                                <td>{{\Carbon\Carbon::parse($product?->inventory?->available_date)->toDayDateTimeString()}}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($product?->inventory?->available_alert_date))
                                            <tr>
                                                <th>Available Alert Date</th>
                                                <td>{{\Carbon\Carbon::parse($product?->inventory?->available_alert_date)?->toDayDateTimeString()}}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($product?->inventory?->expiry_date))
                                            <tr>
                                                <th>Expiry Date</th>
                                                <td>{{\Carbon\Carbon::parse($product?->inventory?->expiry_date)?->toDayDateTimeString()}}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($product?->inventory?->is_available_for_pre_order))
                                            <tr>
                                                <th>Allow Preorder</th>
                                                <td>{{\App\Models\Inventory::AVAILABLE_FOR_PRE_ORDER_LIST[$product?->inventory?->is_available_for_pre_order]??''}}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($product?->inventory->is_available_for_pre_order))
                                            <tr>
                                                <th>Allow Preorder</th>
                                                <td>{{\App\Models\Inventory::AVAILABLE_FOR_PRE_ORDER_LIST[$product?->inventory?->is_available_for_pre_order]??''}}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($product?->inventory?->is_returnable))
                                            <tr>
                                                <th>Is Returnable</th>
                                                <td>{{\App\Models\Inventory::RETURN_ABLE_LIST[$product?->inventory?->is_returnable]??''}}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($product?->inventory?->disable_buy_button))
                                            <tr>
                                                <th>Disable Buy Button</th>
                                                <td>{{\App\Models\Inventory::DISPlAY_BUY_BUTTON_LIST[$product?->inventory?->disable_buy_button]??''}}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($product?->inventory?->is_disable_wishlist_button))
                                            <tr>
                                                <th>Disable Buy Button</th>
                                                <td>{{\App\Models\Inventory::DISABLE_WISHLIST_LIST[$product?->inventory?->is_disable_wishlist_button]??''}}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($product?->inventory?->max_cart_quantity))
                                            <tr>
                                                <th>Max Cart Quantity</th>
                                                <td>{{$product?->inventory?->max_cart_quantity}}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($product?->inventory?->min_cart_quantity))
                                            <tr>
                                                <th>Min Cart Quantity</th>
                                                <td>{{$product?->inventory?->min_cart_quantity}}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($product?->inventory?->allowed_quantity))
                                            <tr>
                                                <th>Allowed Cart Quantity</th>
                                                <td>{{$product?->inventory?->allowed_quantity}}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($product?->inventory?->is_enable_call_for_price))
                                            <tr>
                                                <th>Is Allowed Call for Price</th>
                                                <td>{{\App\Models\Inventory::CALL_FOR_PRICE_LIST[$product?->inventory?->is_enable_call_for_price]??''}}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Linked Data</h4>
                                </div>
                                <div class="card-body px-0">
                                    <table class="table table-bordered table-striped table-hover table-sm">
                                        <tr>
                                            <th>Category</th>
                                            <td>
                                                @if(count($product?->categories) > 0)
                                                    @foreach($product?->categories as $category)
                                                        <button type="button"
                                                                class="btn btn-sm btn-success me-1 mb-1">{{$category->name}}</button>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Stores</th>
                                            <td>
                                                @if(count($product?->stores) > 0)
                                                    @foreach($product?->stores as $store)
                                                        <button type="button"
                                                                class="btn btn-sm btn-info me-1 mb-1">{{$store->store_name}}</button>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Accepted Payment Methods</th>
                                            <td>
                                                @if(count($product?->acceptedPaymentMethods) > 0)
                                                    @foreach($product?->acceptedPaymentMethods as $acceptedPaymentMethod)
                                                        <button type="button"
                                                                class="btn btn-sm btn-success me-1 mb-1">{{$acceptedPaymentMethod->name}}</button>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tags</th>
                                            <td>
                                                @if(count($product?->productTags) > 0)
                                                    @foreach($product?->productTags as $productTag)
                                                        <button type="button"
                                                                class="btn btn-sm btn-info me-1 mb-1">{{$productTag->name}}</button>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Warehouses</th>
                                            <td>
                                                @if(count($product?->warehouses) > 0)
                                                    @foreach($product?->warehouses as $warehouse)
                                                        <button type="button"
                                                                class="btn btn-sm btn-success me-1 mb-1">{{$warehouse->name}}</button>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Product Attributes</th>
                                            <td>
                                                @if(count($product?->productAttributes) > 0)
                                                    @foreach($product?->productAttributes as $productAttribute)
                                                        <button type="button"
                                                                class="btn btn-sm btn-info me-1 mb-1">{{$productAttribute->productAttribute->name}}
                                                            : {{$productAttribute->value}}</button>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Product Specification</th>
                                            <td>
                                                @if(count($product?->productSpecification) > 0)
                                                    @foreach($product?->productSpecification as $productSpecification)
                                                        <button type="button"
                                                                class="btn btn-sm btn-success me-1 mb-1">{{$productSpecification->name}}
                                                            : {{$productSpecification->value}}</button>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(count($product?->photo) > 0)
                        <div class="row mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Product Main Photos</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($product?->photo as $photo)
                                            <div class="col-md-3 mb-4">
                                                <img
                                                    src="{{asset(\App\Models\ProductPhoto::PRODUCT_PHOTO_UPLOAD_PATH_THUMB.$photo->photo)}}"
                                                    class="img-thumbnail"
                                                    alt="photo"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-html="true"
                                                    title="<p><strong>Serial</strong>  : {{$photo->serial}}</p><br/>
                                                <p><strong>Alt text</strong>  : {{$photo->alt_text}}</p><br/>
                                                <p><strong>Title</strong>  : {{$photo->title}}</p>"
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(count($product?->variationPhotosOnly) > 0)
                        <div class="row mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Product Variation Photos</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($product?->variationPhotosOnly as $photo)
                                            <div class="col-md-3 mb-4">
                                                <img
                                                    src="{{asset(\App\Models\ProductPhoto::PRODUCT_PHOTO_UPLOAD_PATH_THUMB.$photo->photo)}}"
                                                    class="img-thumbnail"
                                                    alt="photo"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-html="true"
                                                    title="
                                                <p><strong>Alt text</strong>  : {{$photo->alt_text}}</p><br/>
                                                <p><strong>Title</strong>  : {{$photo->title}}</p>"
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(count($product?->productVariations) > 0)
                        <div class="row mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Variant Products</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Photo</th>
                                            <th>Attributes</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($product?->productVariations as $productVariation)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td><img width="75"
                                                         src="{{asset(\App\Models\ProductPhoto::PRODUCT_PHOTO_UPLOAD_PATH_THUMB.$productVariation?->productVariationPhoto?->photo)}}"
                                                         class="img-thumbnail" alt="Product Variation Image"></td>
                                                <td>
                                                    @if(count($productVariation->variationAttributes))
                                                        @foreach($productVariation->variationAttributes as $variationAttributes)
                                                            <button
                                                                class="btn btn-sm btn-success">{{$variationAttributes->productAttribute->name}}
                                                                : {{$variationAttributes->value}}</button>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>{{$productVariation->productPrice->price}}Tk</td>
                                                <td>{{$productVariation->productInventory->stock}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            @if(count($product?->relatedProducts) > 0)
                                <div class="row mt-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Related Products</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                @foreach($product?->relatedProducts as $relatedProduct)
                                                    <li class="list-group-item">
                                                        <a href="{{route('product.show', $relatedProduct->product->id)}}">
                                                            @if(!empty($relatedProduct?->product?->primaryPhoto?->photo))
                                                                <img width="75"
                                                                     src="{{asset(\App\Models\ProductPhoto::PRODUCT_PHOTO_UPLOAD_PATH_THUMB.$relatedProduct?->product?->primaryPhoto?->photo)}}"
                                                                     class="img-thumbnail" alt="Images">
                                                            @else
                                                                <img width="75" src="{{asset('images/default.webp')}}"
                                                                     class="img-thumbnail" alt="Images">
                                                            @endif

                                                            {{$relatedProduct->product->name}}
                                                        </a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if(count($product?->crossProduct) > 0)
                                <div class="row mt-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Cross Products</h4>
                                        </div>
                                        <div class="card-body">
                                            @foreach($product?->crossProduct as $crossProduct)
                                                <li class="list-group-item">
                                                    <a href="{{route('product.show', $crossProduct->product->id)}}">
                                                        @if(!empty($crossProduct?->product?->primaryPhoto?->photo))
                                                            <img width="75"
                                                                 src="{{asset(\App\Models\ProductPhoto::PRODUCT_PHOTO_UPLOAD_PATH_THUMB.$crossProduct?->product?->primaryPhoto?->photo)}}"
                                                                 class="img-thumbnail" alt="Images">
                                                        @else
                                                            <img width="75" src="{{asset('images/default.webp')}}"
                                                                 class="img-thumbnail" alt="Images">
                                                        @endif
                                                        {{$crossProduct->product->name}}
                                                    </a></li>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Product Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="product-description">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Product Details BN</h4>
                                </div>
                                <div class="card-body">
                                    <div class="product-description">
                                        {!! $product->description_bn !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
