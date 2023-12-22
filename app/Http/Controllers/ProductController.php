<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;

use App\Models\Faq;
use App\Models\Seo;
use App\Models\Tag;

use App\Models\Vendor;
use App\Models\Country;
use App\Models\Product;
use App\Manager\Utility;
use App\Models\Category;
use App\Models\Shipping;
use App\Models\Warrenty;
use App\Models\Attribute;
use App\Models\Warehouse;
use App\Models\Inventorie;

use App\Models\Inventory;
use App\Models\ActivityLog;
use App\Models\Manufacture;
use App\Models\ProductPhoto;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\AttributeValue;
use App\Manager\CommonResponse;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use App\Http\Resources\ShippingResource;
use App\Http\Resources\WarrentyResource;
use App\Manager\ProductVariationManager;
use App\Http\Resources\WarehouseResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\InventoriesResource;
use App\Http\Resources\CategoryListResource;
use App\Http\Resources\ProductPhotoResource;
use App\Http\Resources\ProductPriceResource;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductVariationAttributeResource;

// use Attribute;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $products     = null;
        $page_content = [
            'page_title'      => __('Product List'),
            'module_name'     => __('Product'),
            'sub_module_name' => __('List'),
            'module_route'    => route('product.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns  = Schema::getColumnListing('products');
            $filters  = $request->all();
            $products = (new Product())->getProductList($request);

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('PRODUCT_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('product.index')->with(compact('products', 'page_content',
            'columns', 'filters'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Product Create'),
            'module_name'     => __('Product Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('product.index'),
            'button_type'     => 'list' //create
        ];

        $product              = new Product();
        $inventoryInformation = new Inventory();
        $manufactures         = Manufacture::query()->pluck("name", "id");
        $countries            = Country::query()->pluck("name", "id");
        $vendors              = Vendor::query()->pluck("name", "id");

        $categories         = Category::pluck("name", "id");
        $selectedCategories = [];
        $parentCategory     = Category::all();


        $paymentMethods          = PaymentMethod::query()->pluck("name", "id");
        $selectedPaymentMethods  = [];
        $warehouses              = Warehouse::query()->pluck("name", "id");
        $selectedwarehouses      = [];
        $relatedProducts         = Product::query()->pluck("title", "id");
        $selectedRelatedProducts = [];

        $tags               = Tag::query()->pluck("name", "id");
        $specificationCount = count($product->specifications);
        $attributes         = Attribute::query()->where('status', Attribute::STATUS_ACTIVE)->pluck('name', 'id');
        $attribute_values   = AttributeValue::query()->select('id', 'name', 'attribute_id')->get();


        return view('product.add', compact('page_content', 'categories', 'product',
            'manufactures', 'countries', 'vendors', 'inventoryInformation',
            'relatedProducts', 'paymentMethods', 'warehouses',
            'specificationCount', 'tags', 'attributes', 'attribute_values',
            'selectedCategories', 'selectedPaymentMethods',
            'selectedwarehouses', 'selectedRelatedProducts', 'parentCategory'

        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    private Product|Model $product;
    public ProductPrice|Model $productPrice;
    public Inventory|Model $inventory;
    private Request $request;

    public function store(StoreProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $product       = (new Product())->createNewProduct($request);
            $this->request = $request;
            $this->product = $product;


            // Create Faq
            if ($request->has('faqs')) {
                foreach ($request->input('faqs') as $faqData) {
                    $faq = new Faq([
                        'question_title' => $faqData['question_title'],
                        'status'         => $faqData['status'],
                        'description'    => $faqData['description'],
                        'user_id'        => Auth::id(),
                    ]);
                    $product->faqs()->save($faq);
                }
            }
            // create attribute
            if ($this->request->has('attribute')) {
                (new ProductAttribute())->storeProductAttributData($this->request, $product);
            }

            // create photo
            $productPhoto = new ProductPhoto();
            $productPhoto->processImageUpload($request, $product);

            // Attach selected categories
            $product->categories()->attach($request->input('category_ids'));
            $product->paymentMethods()->attach($request->input('payment_method_ids'));
            $product->warehouses()->attach($request->input('warehouse_ids'));
            $product->relatedProducts()->attach($request->input('ralatedProduct_ids'));

            // Create product price
            $productPriceData   = [
                'product_id'       => $product->id,
                'price'            => $request->input('price'),
                'old_price'        => $request->input('old_price'),
                'discount_info'    => $request->input('discount_info'),
                'discount_fixed'   => $request->input('discount_fixed'),
                'discount_percent' => $request->input('discount_percent'),
                'discount_start'   => $request->input('discount_start'),
                'discount_end'     => $request->input('discount_end'),
                'discount_type'    => $request->input('discount_type'),
                'cost'             => $request->input('cost'),

            ];
            $this->productPrice = ProductPrice::create($productPriceData);

            // create inventories
            $productInventoryData = [

                'product_id'                 => $product->id,
                'is_available_for_pre_order' => $request->input('is_available_for_pre_order'),
                'is_enable_call_for_price'   => $request->input('is_enable_call_for_price'),
                'is_returnable'              => $request->input('is_returnable'),
                'disable_buy_button'         => $request->input('disable_buy_button'),
                'is_disable_wishlist_button' => $request->input('is_disable_wishlist_button'),
                'inventory_method'           => $request->input('inventory_method'),
                'available_date'             => $request->input('available_date'),
                'max_cart_quantity'          => $request->input('max_cart_quantity'),
                'min_cart_quantity'          => $request->input('min_cart_quantity'),
                'stock'                      => $request->input('stock'),
                'low_stock_alert'            => $request->input('low_stock_alert'),
            ];
            $this->inventory      = Inventory::create($productInventoryData);
            // create variation
            if ($this->request->has('var_attribute') && $this->request->has('variations')) {
                $productVariationManager               = new ProductVariationManager();
                $productVariationManager->request      = $this->request;
                $productVariationManager->product      = $this->product;
                $productVariationManager->productPrice = $this->productPrice;
                $productVariationManager->inventory    = $this->inventory;
                $productVariationManager->handleProductVariationStore();
            }

            // Create product Specification
            $specificationsData = $request->input('specifications');

            foreach ($specificationsData as $specData) {
                $productSpecification = new ProductSpecification([
                    'name'       => $specData['name'],
                    'value'      => $specData['value'],
                    'product_id' => $product->id,
                ]);

                $productSpecification->save();
            }


            // create Shipping
            $productShippingData = [
                'product_id'     => $product->id,
                'package_weight' => $request->input('package_weight'),
                'height'         => $request->input('height'),
                'width'          => $request->input('width'),
                'length'         => $request->input('length'),
                'product_type'   => $request->input('product_shipping_type'),
            ];
            Shipping::create($productShippingData);

            // create Shipping
            $productWarrentyData = [
                'product_id'      => $product->id,
                'warrenty_type'   => $request->input('warrenty_type'),
                'warrenty_period' => $request->input('warrenty_period'),
                'warrenty_policy' => $request->input('warrenty_policy'),
            ];
            Warrenty::create($productWarrentyData);


            DB::commit();
            $message = 'New Product added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_PRODUCT_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }


    public function show(Product $product)
    {
        $page_content         = [
            'page_title'      => __('Product Information '),
            'module_name'     => __('Product Details Page'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('product.index'),
            'button_type'     => 'list' //create
        ];
        $products             = Product::with('categories')->get();
        $productprice         = Productprice::where('product_prices.product_id', $product->id)->first();
        $inventoryInformation = Inventory::where('inventories.product_id', $product->id)->first();
        $shippingInfo         = Shipping::where('shippings.product_id', $product->id)->first();
        $warrentyInfo         = Warrenty::where('warrenties.product_id', $product->id)->first();

        $product->load(
            [
                'user',
                'activity_logs',
                'productAttributes',
                'productAttributes.productAttribute',
                'productVariations',
                'productVariations.productVariationPhoto',
                'productVariations.variationAttributes',
                'ProductPhotoWithtVariation',
            ]
        );
        // $variationPhoto       = ProductPhoto::where('product_photos.variation_id',$product->id);
        return view('product.show', compact('product', 'products',
            'page_content', 'productprice', 'inventoryInformation',
            'shippingInfo', 'warrentyInfo'
        ));
    }
    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // dd($product);
        $page_content = [
            'page_title'      => __('Product Information Edit'),
            'module_name'     => __('Product Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('product.index'),
            'button_type'     => 'list' //create
        ];
        $product->load([
            'seos',
            'faqs',
            'product_price',
            'ProductPhotos',
            'productAttributes',
            'productAttributes.productAttribute',
            'productVariations.productPrice',
            'productVariations.productInventory',
            'productVariations.variationAttributes',
            'productVariations.productVariationPhoto',
            'productVariations.variationAttributes.productAttribute',
        ]);

        // $product->load('faqs');

        // $categories              = Category::pluck("name", "id");
        // $selectedCategories      = $product->categories->pluck('id')->toArray();
        // $parentCategory          = Category::all();
        $categories     = Category::pluck("name", "id");
        $parentCategory = Category::all();

        // Populate $selectedCategories with the IDs of the product's associated categories
        $selectedCategories = $product->categories->pluck('id')->toArray();


        $paymentMethods         = PaymentMethod::query()->pluck("name", "id");
        $selectedPaymentMethods = $product->paymentMethods->pluck('id')->toArray();

        $warehouses         = Warehouse::query()->pluck("name", "id");
        $selectedwarehouses = $product->warehouses->pluck('id')->toArray();

        $relatedProducts         = Product::pluck('title', 'id');
        $selectedRelatedProducts = $product->relatedProducts->pluck('id')->toArray();

        $manufactures = Manufacture::query()->pluck("name", "id");
        $countries    = Country::query()->pluck("name", "id");
        $vendors      = Vendor::query()->pluck("name", "id");
        // $inventoryInformation    = Inventory::all();
        $inventoryInformation = Inventory::where('product_id', $product->id)->first();
        // $shippingInfo            = Shipping::where('product_id', $product->id)->first();

        $productprice       = ProductPrice::all();
        $productPhoto       = ProductPhoto::all();
        $existingPhotos     = $product->ProductPhotos;
        $specificationCount = count($product->specifications);
        $attributes         = Attribute::query()->where('status', Attribute::STATUS_ACTIVE)->pluck('name', 'id');
        $attribute_values   = AttributeValue::query()->select('id', 'name', 'attribute_id')->get();

        // $tags = Tag::pluck("name", "id");

        return view('product.edit', compact('page_content', 'product',
            'categories', 'selectedCategories', 'manufactures',
            'countries', 'vendors', 'relatedProducts', 'selectedRelatedProducts',
            'paymentMethods', 'selectedPaymentMethods', 'warehouses', 'selectedwarehouses'
            , 'productprice', 'inventoryInformation', 'productPhoto',
            'specificationCount', 'attributes', 'attribute_values'
            , 'existingPhotos', 'parentCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();
            $original = $product->getOriginal();
            $updated  = (new Product())->updateProductInfo($request, $product);
            $changed  = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $product);
            // (new Product())->updateProductInfo($request,$product);
            $this->request = $request;
            $this->product = $product;

            if ($request->has('category_ids')) {
                $product->categories()->sync($request->input('category_ids'));
            }
            if ($request->has('payment_method_ids')) {
                $product->paymentMethods()->sync($request->input('payment_method_ids'));
            }
            if ($request->has('warehouse_ids')) {
                $product->warehouses()->sync($request->input('warehouse_ids'));
            }
            if ($request->has('ralatedProduct_ids')) {
                $product->relatedProducts()->sync($request->input('ralatedProduct_ids'));
            }

            // Update or create FAQ entries
            if ($request->has('faqs')) {
                $product->faqs()->delete();//existing delete
                foreach ($request->input('faqs') as $faqData) {
                    if (isset($faqData['id'])) {
                        $faq = Faq::find($faqData['id']);
                        $faq->update([
                            'question_title' => $faqData['question_title'],
                            'status'         => $faqData['status'],
                            'description'    => $faqData['description'],
                            'user_id'        => Auth::id(),
                        ]);
                    } else {
                        // Create new FAQ
                        $faq = new Faq([
                            'question_title' => $faqData['question_title'],
                            'status'         => $faqData['status'],
                            'description'    => $faqData['description'],
                            'user_id'        => Auth::id(),
                        ]);
                        $product->faqs()->save($faq);
                    }
                }
            }

            // update Specification
            if ($request->has('specifications')) {
                $product->specifications()->delete(); // Remove existing specifications
                foreach ($request->input('specifications') as $specificationData) {
                    $specification = new ProductSpecification([
                        'name'  => $specificationData['name'],
                        'value' => $specificationData['value'],
                    ]);
                    $product->specifications()->save($specification);
                }
            }
            // update Product Price
            // $this->productPrice = Productprice::where('product_prices.product_id',$product->id)->whereNull('variation_id')->first();
            // $productprice = $this->productPrice;

            $productprice = Productprice::where('product_prices.product_id', $product->id)->whereNull('variation_id')->first();

            if ($request->has('price')) {
                $productPriceData = [
                    'price'         => $request->input('price') ?? $productprice->price,
                    'cost'          => $request->input('cost') ?? $productprice->cost,
                    'discount_type' => $request->input('discount_type') ?? $productprice->discount_type,
                ];

                if ($productprice) {
                    $productprice->update($productPriceData);
                }

            }

            if ($request->has('discount_type')) {
                $discountType = $request->input('discount_type');

                $productPriceData = [
                    'discount_type'    => $discountType,
                    'discount_fixed'   => null,
                    'old_price'        => null,
                    'discount_percent' => null,
                    'discount_start'   => null,
                    'discount_end'     => null,
                    'discount_info'    => null,

                ];

                if ($discountType == 0) {
                    $productPriceData = [
                        'discount_info'    => $request->input('discount_info') ?? $productprice->discount_info,
                        'old_price'        => $request->input('old_price') ?? $productprice->old_price,
                        'discount_fixed'   => null,
                        'discount_percent' => null,
                        'discount_start'   => $request->input('discount_start') ?? $productprice->discount_start,
                        'discount_end'     => $request->input('discount_end') ?? $productprice->discount_end,
                    ];


                } elseif ($discountType == 1) {
                    $productPriceData = [
                        'discount_info'    => null,
                        'old_price'        => null,
                        'discount_fixed'   => $request->input('discount_fixed') ?? $productprice->discount_fixed,
                        'discount_percent' => $request->input('discount_percent') ?? $productprice->discount_percent,
                        'discount_start'   => $request->input('discount_start') ?? $productprice->discount_start,
                        'discount_end'     => $request->input('discount_end') ?? $productprice->discount_end,
                    ];

                }
                if ($productprice) {
                    $productprice->update($productPriceData);
                }
            }
            // inventory Update
            // $this->inventory      = Inventory::where('inventories.product_id',$product->id)->whereNull('variation_id')->first();
            // $inventoryInformation = $this->inventory;
            $inventoryInformation = Inventory::where('inventories.product_id', $product->id)->whereNull('variation_id')->first();
            if ($request->has('stock')) {
                $productInventoryData = [
                    'product_id'                 => $product->id,
                    'is_available_for_pre_order' => $request->input('is_available_for_pre_order') ?? $inventoryInformation->is_available_for_pre_order,
                    'is_enable_call_for_price'   => $request->input('is_enable_call_for_price') ?? $inventoryInformation->s_enable_call_for_price,
                    'is_returnable'              => $request->input('is_returnable') ?? $inventoryInformation->is_returnable,
                    'disable_buy_button'         => $request->input('disable_buy_button') ?? $inventoryInformation->disable_buy_button,
                    'is_disable_wishlist_button' => $request->input('is_disable_wishlist_button') ?? $inventoryInformation->is_disable_wishlist_button,
                    'inventory_method'           => $request->input('inventory_method') ?? $inventoryInformation->inventory_method,
                    'available_date'             => $request->input('available_date') ?? $inventoryInformation->available_date,
                    'max_cart_quantity'          => $request->input('max_cart_quantity') ?? $inventoryInformation->max_cart_quantity,
                    'min_cart_quantity'          => $request->input('min_cart_quantity') ?? $inventoryInformation->min_cart_quantity,
                    'stock'                      => $request->input('stock') ?? $inventoryInformation->stock,
                    'low_stock_alert'            => $request->input('low_stock_alert') ?? $inventoryInformation->low_stock_alert,
                ];
                $inventoryInformation = $product->inventories->first();
                if ($inventoryInformation) {
                    $inventoryInformation->update($productInventoryData);
                }

            }
            // Photo Update
            // $productPhoto = ProductPhoto::where('product_photos.product_id',$product->id)->first();

            // Update product photos
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    if ($photo && $photo->isValid()) {
                        // Process the image upload and save product photo data
                        $photoPath = $photo->store('product_photos', 'public');

                        ProductPhoto::create([
                            'product_id'   => $product->id,
                            'variation_id' => null,
                            'title'        => $request->input('title'), // Replace with the actual title
                            'alt_text'     => $request->input('alt_text'), // Replace with the actual alt text
                            'serial'       => $request->input('serial'), // Replace with the actual serial
                            'photo'        => $photoPath,
                        ]);
                    }
                }
            }


            // if ($request->has('photos')) {
            //     $productPhotos = ProductPhoto::where('product_id', $product->id)->get();

            //     foreach ($productPhotos as $productPhoto){
            //         $productPhotoData = [
            //             'title'    => $productPhoto->title,
            //             'alt_text' => $productPhoto->alt_text,
            //             'serial'   => $productPhoto->serial,
            //             'photo'    => $productPhoto->photo,
            //         ];
            //         $productPhoto->update($productPhotoData);
            //     }

            //     foreach ($productPhotos as $productPhoto) {
            //         ImageUploadManager::deletePhoto('uploads/product/', $productPhoto->photo);
            //         $productPhoto->delete();
            //     }

            //     (new ProductPhoto())->processImageUpload($request, $product);
            // }

            // shipping Update
            $shippingInfo = Shipping::where('shippings.product_id', $product->id)->first();
            if ($request->has('package_weight')) {
                $productShippingData = [
                    'product_id'     => $product->id,
                    'package_weight' => $request->input('package_weight') ?? $shippingInfo->package_weight,
                    'height'         => $request->input('height') ?? $shippingInfo->height,
                    'width'          => $request->input('width') ?? $shippingInfo->width,
                    'length'         => $request->input('length') ?? $shippingInfo->length,
                    'product_type'   => $request->input('product_shipping_type') ?? $shippingInfo->product_type,
                ];
                $shippingInfo        = $product->shipping->first();
                if ($shippingInfo) {
                    $shippingInfo->update($productShippingData);
                }
            }

            // Warrenty Update
            $warrentyInfo = Warrenty::where('warrenties.product_id', $product->id)->first();
            if ($request->has('warrenty_type')) {
                $productWarrentyData = [
                    'product_id'      => $product->id,
                    'warrenty_type'   => $request->input('warrenty_type') ?? $warrentyInfo->warrenty_type,
                    'warrenty_period' => $request->input('warrenty_period') ?? $warrentyInfo->warrenty_period,
                    'warrenty_policy' => $request->input('warrenty_policy') ?? $warrentyInfo->warrenty_policy,
                ];
                $warrentyInfo        = $product->warrenty->first();
                if ($warrentyInfo) {
                    $warrentyInfo->update($productWarrentyData);
                }
            }

            // variation update
            //  $flag_update = true;

            // if (!empty($request->input('variations'))) {
            //     foreach ($request->input('variations') as $variations) {
            //         if (!is_numeric($variations['id'])) {
            //             $flag_update = false;
            //         }
            //     }
            // }


            // if ($flag_update && !empty($request->input('variations'))) {
            //     foreach ($request->input('variations') as $variations) {
            //         if (is_numeric($variations['id'])) {
            //             $variation_data = [
            //                 'data'  => json_encode($variations['data'], JSON_THROW_ON_ERROR),
            //                 'price' => $variations['price'],
            //             ];
            //             ProductVariation::query()->where('id', $variations['id'])->update($variation_data);
            //             ProductPrice::query()->where('variation_id', $variations['id'])->update(['price' => $variations['price']]);
            //         }
            //     }
            // } else {
            //     if ($this->request->has('var_attribute') && $this->request->has('variations')) {
            //         $productVariationManager               = new ProductVariationManager();
            //         $productVariationManager->request      = $this->request;
            //         $productVariationManager->product      = $this->product;
            //         $productVariationManager->productPrice = $this->productPrice;
            //         $productVariationManager->inventory    = $this->inventory;
            //         $productVariationManager->handleProductVariationStore();
            //     }
            // }


            // if ($this->request->input('product_type') == Product::PRODUCT_TYPE_GROUPED && $this->request->has('deleted_variant')) {
            //     $variant_ids = json_decode($this->request->input('deleted_variant'), true);
            //     if (!empty($variant_ids)) {
            //         ProductVariation::query()->whereIn('id', $variant_ids)->delete();
            //         Inventory::query()->whereIn('variation_id', $variant_ids)->delete();
            //         ProductPrice::query()->whereIn('variation_id', $variant_ids)->delete();
            //     }
            // }

            DB::commit();
            $message = 'Product Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('PRODUCT_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();
            $product->seos()->delete();
            $original = $product->getOriginal();
            $changed  = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $product);
            $product->ProductPhotos()->delete();
            $product->inventories()->delete();
            $product->faqs()->delete();
            $product->specifications()->delete();
            $product->shipping()->delete();
            $product->warrenty()->delete();
            $product->productAttributesAll()->delete();
            $product->productVariations()->delete();


            // ProductPhoto::where('product_photos.product_id',$product->id)->delete();

            $product->delete();
            DB::commit();
            $message = 'Product Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('PRODUCT_INFORMATION_DELETE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }


    final public function getProductList(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams = [
                'search'   => $request->all(),
                'order_by' => 'display_order',
            ];

             $productList = (new Product())->getProductsForApi($request);
           // $products = Product::all();

            // Extract the data from the collection
           // $commonResponse->data =  ProductResource::collection($products);
             $commonResponse->data = [
                 'products'      => ProductResource::collection($productList['product']),
                 'total_product' => $productList['total_product']
             ];

            $commonResponse->status_message = __('Product Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_PRODUCT_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

    final public function getProductWithFilter(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams = [
                'search'          => $request->all(),
                'order_by'        => $request->get('sort_column', 'display_order'),
                'order_direction' => $request->get('sort_direction', 'asc'),
            ];

            $productListQuery = Product::query();

            if ($request->has('min_price')) {
                $productListQuery->whereHas('prices', function ($query) use ($request) {
                    $query->where('price', '>=', $request->get('min_price'));
                });
            }

            if ($request->has('max_price')) {
                $productListQuery->whereHas('prices', function ($query) use ($request) {
                    $query->where('price', '<=', $request->get('max_price'));
                });
            }

            if ($request->has('category')) {
                $categorySlug = $request->get('category');
                $productListQuery->whereHas('categories', function ($query) use ($categorySlug) {
                    $query->where('slug', $categorySlug);
                });
            }

            $orderDirection = $request->get('sort_direction', 'asc');
            $productListQuery->join('product_prices', 'products.id', '=', 'product_prices.product_id')
                ->select('products.*')
                ->orderBy('product_prices.price', $orderDirection);

            $perPage     = $request->get('per_page', 10);
            $productList = $productListQuery->distinct('products.id')->paginate($perPage);

            $commonResponse->data           = ProductResource::collection($productList)->response()->getData();
            $commonResponse->status_message = __('Product Data fetched successfully');

        } catch (\Throwable $throwable) {
            Log::info('API_PRODUCT_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

    public function getProductBySlug(Request $request)
    {
        $commonResponse = new CommonResponse();
        try {
            $slug    = $request->query('id');
            $product = Product::where('slug', $slug)->first();

            if (!$product) {
                $commonResponse->status_message = 'Product not found';
                $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
                $commonResponse->status         = false;
                return $commonResponse->commonApiResponse();
            }

            $productResource      = new ProductResource($product);
            $formattedProductData = $productResource->response()->getData();

            // Extract the product data from the response
            $commonResponse->data = $formattedProductData->data;

            $commonResponse->status_message = __('Product Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_PRODUCT_FETCH_BY_SLUG_FAILED', ['slug' => $slug, 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }

        return $commonResponse->commonApiResponse();
    }


    public function getProductDetail(Request $request, string $slug)
    {
        $commonResponse = new CommonResponse();
        try {
            $product = Product::query()->where('slug', $slug)->first();

            if (!$product) {
                $commonResponse->status_message = 'Product not found';
                $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
                $commonResponse->status         = false;
                return $commonResponse->commonApiResponse();
            }

            $productResource      = new ProductDetailResource($product);
            $formattedProductData = $productResource->response()->getData();
            $commonResponse->data = $formattedProductData->data;

            $commonResponse->status_message = __('Product Details By Slug Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_PRODUCT_DETAILS_FETCH_BY_SLUG_FAILED', ['slug' => $slug, 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }

        return $commonResponse->commonApiResponse();
    }



//     public function getProductDetail(Request $request, $slug)
// {

//     $commonResponse = new CommonResponse();
//     try {
//         $product = Product::where('slug', $slug)->first();
//         dd($slug);

//         if (!$product) {
//             $commonResponse->status_message = 'Product not found';
//             $commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;
//             $commonResponse->status = false;
//             return $commonResponse->commonApiResponse();
//         }

//         $productAttributesGrouped = $product->productAttributesAll->groupBy('AttributeName.name');

//         $productVariationsAttributeList = $productAttributesGrouped->map(function ($attributes, $attributeName) {
//             $uniqueValues = $attributes->pluck('value')->unique()->values()->toArray();

//             return [
//                 'name' => $attributeName,
//                 'value' => $uniqueValues,
//             ];
//         })->values();

//         // Construct the response data using the $product object
//         $responseData = [
//         //**************** */
//             'id'                   => $product->id,
//             'title'                => $product->title,
//             'slug'                 => $product->slug,
//             'photo'                => ProductPhotoResource::collection($product->ProductPhotos->where('variation_id', null)),
//             'Seo'                  => $product->seos ? [
//                                         'id' => $product->seos->id,
//                                         'title' => $product->seos->title,
//                                         'keywords' => $product->seos->keywords,
//                                         'description' => $product->seos->description,
//                                         'og_image' => $product->seos->og_image ? url(Seo::Seo_PHOTO_UPLOAD_PATH. $product->seos->og_image) : null,
//                                     ] : null,
//             'price'                  => $product->product_price ? [
//                                             'id' => $product->product_price->id,
//                                             'variation_id' => $product->product_price->variation_id,
//                                             'product_id' => $product->product_price->product_id,
//                                             'price' => $product->product_price->price,
//                                             'cost' => $product->product_price->cost,
//                                             'discount_type' => $product->product_price->discount_type,
//                                             'discount_info' => $product->product_price->discount_info,
//                                             'old_price' => $product->product_price->old_price,
//                                             'discount_fixed' => $product->product_price->discount_fixed,
//                                             'discount_percent'=> $product->product_price->discount_percent,
//                                             'discount_start'  =>Carbon::parse($product->product_price->discount_start)->format('D, M j, Y, H:i'),
//                                             'discount_end'    =>Carbon::parse($product->product_price->discount_end)->format('D, M j, Y, H:i'),
//                                         ] : null,
//             'sku'                  => $product->sku,
//             'model'                => $product->model,
//             'product_type'         => $product->product_type,
//             'product_type_text'    => $product->product_type == 1 ? 'Simple':'Grouped With Variation',
//             'is_published'         => $product->is_published == 1? 'Pending':($product->is_published == 2? 'Published':'Not Published'),
//             'is_show_on_home_page' => $product->is_show_on_home_page == 1 ?'Yes' : 'No',
//             'is_allow_review'      => $product->is_allow_review == 1 ? 'Allowed' : 'Not Allowed',
//             'is_new'               => $product->is_new == 1 ? 'New' : 'Not New',
//             'is_prime'             => $product->is_prime == 1 ? 'Prime' : 'Not Prime',
//             'sort_order'           => $product->sort_order,
//             'description'          => strip_tags(html_entity_decode($product->description)),
//             'short_description'    => $product->short_description,
//             'comment'              => $product->comment,

//             'country'              => $product->country?->name,
//             //   'country'              => $product->country ? $product->country->name : null,

//             'manufacturer'         => $product->manufacture?->name,
//             'vendor'               => $product->vendor?->name,
//             //   'warehouse'            => $product->warehouses->pluck('name')->implode(', '),
//             'warehouse'            => WarehouseResource::collection($product->warehouses),
//             //   'Payment Method'         =>$product->paymentMethods->pluck('name')->implode(', '),
//             'Payment_method'       => PaymentMethodResource::collection($product->paymentMethods),

//             'categories'           => CategoryListResource::collection($product->categories),

//             'inventory'            => InventoriesResource::collection($product->inventoriesForApi),
//             //   'Price'                => ProductPriceResource::collection($product->product_price),
//             'Specification'        => $product->specifications->map(function($specification){
//                                                 return[
//                                                     'name' => $specification->name,
//                                                     'value' => $specification->value,
//                                                 ];
//                                             })->toArray(),
//             'shipping'              => $product->shipping ? new ShippingResource($product->shipping) : null,
//             'warrenty'              => $product->warrenty ? new WarrentyResource($product->warrenty) : null,

//             'Faqs'                 =>  $product->faqs->map(function($faq){
//                                                 return[
//                                                     // 'faq id'=>$faq->faqable_id,
//                                                     'question_title' => $faq->question_title,
//                                                     'description'    => $faq->description,
//                                                     'status'         =>$faq->status==1 ? 'Active':'Inactive',
//                                                 ];
//                                             })->toArray(),
//             'related_products'     => ProductResource::collection($product->relatedProducts),
//             'Product_variations'   => $product->productVariations->map(function($variation){
//                                             return[
//                                                 'id'    =>$variation->id,
//                                                 'product_variation_photo' => new ProductPhotoResource($variation->productVariationPhoto),
//                                                 'variation_attributes'    => ProductVariationAttributeResource::collection($variation->variationAttributes),
//                                                 'variation_price'         => new ProductPriceResource($variation->productPrice),
//                                                 'variation_inventory'     => new InventoriesResource($variation->productInventory),
//                                             ];
//                                         })->toArray(),
//             'product_variations_attribute_list' => $productVariationsAttributeList,

//         // ****************
//         ];

//         $commonResponse->data = $responseData;
//         $commonResponse->status_message = __('Product Data fetched successfully');
//     } catch (\Throwable $throwable) {
//         Log::info('API_PRODUCT_FETCH_BY_SLUG_FAILED', ['slug' => $slug, 'error' => $throwable]);
//         $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
//         $commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;
//         $commonResponse->status = false;
//     }

//     return $commonResponse->commonApiResponse();
// }


}








