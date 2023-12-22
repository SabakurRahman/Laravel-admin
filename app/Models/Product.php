<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const PRODUCT_SIMPLE = 1;
    public const PRODUCT_TYPE_GROUPED = 2;

    public const PRODUCT_TYPE_LIST = [
        self::PRODUCT_SIMPLE       => 'Simple',
        self::PRODUCT_TYPE_GROUPED => 'Grouped With Variant',
    ];

    public const STATUS_PENDING = 1;
    public const STATUS_PUBLISHED = 2;
    public const STATUS_NOT_PUBLISHED = 3;

    public const STATUS_LIST = [
        self::STATUS_PENDING       => 'Pending',
        self::STATUS_PUBLISHED     => 'Published',
        self::STATUS_NOT_PUBLISHED => 'Not Published',
    ];

    public const IS_SAVED = 1;
    public const IS_NOT_SAVED = 2;



    final public function scopeSaved(Builder $query): Builder
    {
        return $query->where('is_saved', self::IS_SAVED);
    }
    final public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', self::STATUS_PUBLISHED);
    }
    final public function scopeNew(Builder $query): Builder
    {
        return $query->where('is_new', 1);
    }

  public function getProductsForApi(Request $request)
{


    $query = self::query()->published()->saved();


    if ($request->input('category_slug')) {
        $category = Category::where('slug', $request->input('category_slug'))->first();
        if ($category) {
            $query->whereHas('categories', function ($cq) use ($category) {
                $cq->where('category_product.category_id', $category->id);
            });
        }
    }

    $productsData = [
        'product' => $query->take($request->input('count'))->get(),
        'total_product' => $query->count(),
    ];

    return $productsData;
}



    // public function getProductsForApi(Request $request)
    // {
    //     $query = self::query()->published()->saved();

    //     if ($request->input('category_slug')) {
    //         $category = (new Category())->getCategoryBySlug($request->input('category_slug'));
    //         if ($category) {
    //             $query->whereHas('categories', function ($cq) use ($category) {
    //                 $cq->where('category_product.category_id', $category->id);
    //             });
    //         }
    //     }

    //     if ($request->has('min_price')) {
    //         $query->whereHas('prices', function ($query) use ($request) {
    //             $query->where('price', '>=', $request->input('min_price'));
    //         });
    //     }


    //     if ($request->input('max_price') && ($request->input('min_price') || $request->input('min_price') == 0)) {
    //         $query->whereHas('price', function ($qs) use ($request) {
    //             $qs->whereNull('variation_id')->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
    //         });
    //     }

    //     if ($request->input('sort_column')) {
    //         if ($request->input('sort_column') == 'price') {
    //             $query->whereHas('price', function ($qp) use ($request) {
    //                 $qp->orderBy($request->input('sort_column'), $request->input('sort_direction') ?? 'asc');
    //             });
    //         } else {
    //             $query->orderBy($request->input('sort_column'), $request->input('sort_direction') ?? 'asc');
    //         }
    //     }

    //     return [
    //         'total_product' => $query->count(),
    //         'product'       => $query->take($request->input('count'))->get()
    //     ];
    // }

    public function getProductList(Request $request)
    {
        // return self::query()->paginate(10);
        $paginate = $request->input('per_page') ?? 10;
        $query    = self::query()->with(['user']);
        if ($request->input('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }
        if ($request->input('sku')) {
            $query->where('sku', 'like', '%' . $request->input('sku') . '%');
        }
        if ($request->input('model')) {
            $query->where('model', 'like', '%' . $request->input('model') . '%');
        }
        if ($request->input('product_type')) {
            $query->where('product_type', $request->input('product_type'));
        }

        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

    public function createNewProduct(StoreProductRequest $request)
    {
        // return self::query()->create($this->prepareNewProductData($request));
        $product = self::query()->create($this->prepareNewProductData($request));
        $seoData = (new Seo)->prepareSeoData($request);
        $product->seos()->create($seoData);

        return $product;
    }

    private function prepareNewProductData(StoreProductRequest $request)
    {
        $country     = Country::find($request->input('country_id'));
        $manufacture = Manufacture::find($request->input('manufacturer_id'));
        $vendor      = Vendor::find($request->input('vendor_id'));
        $warehouse   = Warehouse::find($request->input('warehouse_id'));
        // $parentCategory = Category::find($request->input('category_id'));


        $data = [
            'title'                => $request->input('title'),
            'slug'                 => $request->input('slug'),
            'sku'                  => $request->input('sku'),
            'model'                => $request->input('model'),
            'product_type'         => $request->input('product_type'),
            'is_published'         => $request->input('is_published'),
            'is_show_on_home_page' => $request->input('is_show_on_home_page'),
            'is_allow_review'      => $request->input('is_allow_review'),
            'is_new'               => $request->input('is_new'),
            'is_prime'             => $request->input('is_prime'),
            'sort_order'           => $request->input('sort_order'),
            'description'          => $request->input('description'),
            'short_description'    => $request->input('short_description'),
            'comment'              => $request->input('comment'),
            'country_id'           => $request->input('country_id'),
            'warehouse_id'         => $request->input('warehouse_id'),
            'manufacturer_id'      => $request->input('manufacturer_id'),
            'vendor_id'            => $request->input('vendor_id'),
            // 'category_id'          => $request->input('category_id'),
            'user_id'              => Auth::id(),
        ];
        return $data;
    }

    public function updateProductInfo(Request $request, Product $product)
    {
        $country     = Country::find($request->input('country_id'));
        $manufacture = Manufacture::find($request->input('manufacturer_id'));
        $vendor      = Vendor::find($request->input('vendor_id'));
        $warehouse   = Warehouse::find($request->input('warehouse_id'));
        // $parentCategory = Category::find($request->input('category_id'));


        $updateProductInfoData = [

            'title'                => $request->input('title') ?? $product->title,
            'slug'                 => $request->input('slug') ?? $product->slug,
            'sku'                  => $request->input('sku') ?? $product->sku,
            'model'                => $request->input('model') ?? $product->model,
            'product_type'         => $request->input('product_type') ?? $product->product_type,
            'is_published'         => $request->input('is_published') ?? $product->is_published,
            'is_show_on_home_page' => $request->input('is_show_on_home_page') ?? $product->is_show_on_home_page,
            'is_allow_review'      => $request->input('is_allow_review') ?? $product->is_allow_review,
            'is_new'               => $request->input('is_new') ?? $product->is_new,
            'is_prime'             => $request->input('is_prime') ?? $product->is_prime,
            'sort_order'           => $request->input('sort_order') ?? $product->sort_order,
            'description'          => $request->input('description') ?? $product->description,
            'short_description'    => $request->input('short_description') ?? $product->short_description,
            'comment'              => $request->input('comment') ?? $product->comment,
            'country_id'           => $request->input('country_id') ?? $product->country_id,
            'warehouse_id'         => $request->input('warehouse_id') ?? $product->warehouse_id,
            'manufacturer_id'      => $request->input('manufacturer_id') ?? $product->manufacturer_id,
            'vendor_id'            => $request->input('vendor_id') ?? $product->vendor_id,
            // 'category_id'          =>$request->input('category_id')?? $product->category_id,
            'user_id'              => Auth::id()
        ];
        $product->update($updateProductInfoData);
        if ($product->seos) {
            $seoData = (new Seo)->updateSeo($request, $product->seos);
            $product->seos()->update($seoData);
        } else {
            $seoData = (new Seo)->prepareSeoData($request);
            $product->seos()->create($seoData);
        }

        return $product;

        // return $product->update($updateProductInfoData);
    }

    public function getFullHierarchyAttribute()
    {
        $hierarchy = Category::pluck('name');
        $parent    = $this->categories->parentCategory;

        while ($parent) {
            $hierarchy = $parent->name . ' >> ' . $hierarchy;
            $parent    = $parent->parentCategory;
        }

        return $hierarchy;
    }

    public function getProductsNameId()
    {
        return self::query()->with('prices','productVariations')->get();
    }



    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function paymentMethods(): BelongsToMany
    {
        return $this->belongsToMany(PaymentMethod::class);
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class);
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'related_products', 'product_id', 'related_product_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function prices()
    {
        // return $this->hasOne(ProductPrice::class);
        return $this->hasMany(ProductPrice::class);
    }

    final public function price()
    {
        return $this->hasOne(ProductPrice::class)->whereNull('variation_id');
    }

    final public function product_price()
    {
        return $this->hasOne(ProductPrice::class)->whereNull('variation_id');
    }

    public function inventories()
    {
        return $this->hasOne(Inventory::class)->whereNull('variation_id');
        // return $this->hasMany(Inventory::class);
    }

    public function inventoriesForApi()
    {
        return $this->hasMany(Inventory::class);
    }

    final public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class)->whereNull('variation_id');
    }

    final public function productAttributesAll(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    final public function productAttributesListForApi(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    final public function productVariations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class, 'product_id', 'id');
    }

    public function warrenty()
    {
        return $this->hasOne(Warrenty::class);
    }

    public function ProductPhotos()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function ProductPhotoWithoutVariation()
    {
        return $this->hasMany(ProductPhoto::class)->whereNull('variation_id');
    }

    public function ProductPhotoWithtVariation()
    {
        return $this->hasMany(ProductPhoto::class)->whereNotNull('variation_id');
    }


    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class, 'manufacturer_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function faqs()
    {
        return $this->morphMany(Faq::class, 'faqable');
    }

    public function seos()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphMany
     */
    final public function activity_logs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }


    /**
     * @param int $product_id
     * @param int $quantity
     * @return void
     */
    final public function updateSold(int $product_id, int $quantity): void
    {
        $product = self::query()->findOrFail($product_id);
        if ($product) {
            $product_data = [
                'sold' => $product->sold + $quantity
            ];
            $product->update($product_data);
        }
    }




}




