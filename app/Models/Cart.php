<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function storeCartData(Request $request, $user_id)
    {
        $existingCartItem = self::query()->where('user_id', $user_id)
            ->where('product_id', $request->input('product_id'))
            ->first();

        if ($existingCartItem) {
            return $validation_message = 'This product already in your cart';
        } else {
            self::query()->create($this->prepareCartData($request, $user_id));
            $userCartData = self::query()->where('user_id', $user_id)
                ->orderBy('created_at', 'desc')
                ->get();

        }

        return $userCartData;

    }

    private function prepareCartData(Request $request, $user_id)
    {
        return [
            'product_id'   => $request->input('product_id'),
            'quantity'     => $request->input('quantity'),
            'user_id'      => $user_id,
            'variation_id' => $request->input('variation_id')
        ];
    }


    public function allCartList(Request $request)
    {
        $carts = self::query()->with([
            'user',
            'product'
        ])->paginate(10);
        $carts = $carts->setCollection($carts->groupBy(function ($item) {
            return $item->user?->name;
        })->map(function ($cart) {
            return ['data' => $cart, 'total_items' => $cart->count(), 'total_quantity' => $cart->sum('quantity')];
        }));

        return $carts;

    }

    public function getProductQuantityInUserCart($user_id)
    {
        $cartItems = self::query()
            ->where('user_id', $user_id)
            ->with('product')
            ->get();

        $userCartProducts = [];

        foreach ($cartItems as $cartItem) {
            $userCartProducts[] = [
                'product_name' => $cartItem?->product?->title,
                'quantity'     => $cartItem->quantity,
            ];
        }

        return $userCartProducts;
    }

    public function getUserCarts(int|string|null $id)
    {
        return self::query()->where('user_id', $id)->with(
            [
                'product',
                'product.productAttributes',
                'productVariations',
                'productVariations.variationAttributes',
                'productVariations.variationAttributes.productAttribute',
                'productVariations.productPrice'
            ]
        )->get();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    final public function cartValidation(Request $request, int $user_id): string
    {
        $validation_message = '';
        $product            = Product::query()->findOrFail($request->input('product_id'));
        if (empty($product)) {
            $validation_message = 'Invalid Variation or Product ID';
        } else if ($product->product_type == Product::PRODUCT_TYPE_GROUPED && empty($request->input('variation_id'))) {
            $validation_message = 'Variant product require variation id';
        }

        if ($request->has('variation_id')) {
            $inventory = Inventory::query()->where('variation_id', $request->input('variation_id'))->first();
            $cart      = self::query()->where('product_id', $request->input('product_id'))->where('variation_id', $request->input('variation_id'))->where('user_id', $user_id)->first();
        } else {
            $inventory = Inventory::query()->where('product_id', $request->input('product_id'))->whereNull('variation_id')->first();
            $cart      = self::query()->where('product_id', $request->input('product_id'))->where('user_id', $user_id)->first();
        }
        if ($cart) {
            $validation_message = 'This product already in your cart';
        }
        if ($inventory) {
            if ($inventory->stock < $request->input('quantity')) {
                $validation_message = 'Not enough stock';
            }
        } else {
            $validation_message = 'Invalid Variation or Product ID';
        }
        $product = Product::query()->findOrFail($request->input('product_id'));
        if (!$product || $product->is_out_of_stock == 1) {
            $validation_message = 'Sorry you can not buy this product';
        }
        return $validation_message;
    }


    final public function productVariations()
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }

    final public function cartUpdateValidation(Request $request, Cart|Model $cart): string
    {
        $validation_message = '';
        if ($cart->product->product_type == Product::PRODUCT_TYPE_GROUPED) {
            //grouped
            if ($cart->productVariations->productInventory->stock < $request->input('quantity')) {
                $validation_message = 'Not enough stock';
            }
        } else {
            //simple
            if ($cart->product->inventories->stock < $request->input('quantity')) {
                $validation_message = 'Not enough stock';
            }
        }
        return $validation_message;
    }

    final public function updateCartData(Request $request, Cart $cart): bool
    {
        return $cart->update([
            'quantity'     => $request->input('quantity') ?? $cart->quantity,
            'variation_id' => $request->input('variation_id') ?? $cart->variation_id,
        ]);
    }

}
