<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartUpdateRequest;
use App\Http\Resources\CartDetailResource;
use App\Manager\CommonResponse;
use App\Models\BlogComment;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Faq;
use App\Models\FaqPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Throwable;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_content = [
            'page_title'      => __('Cart List'),
            'module_name'     => __('Cart'),
            'sub_module_name' => __('List'),
        ];
        $columns      = Schema::getColumnListing('carts');
        $filters      = $request->all();
        $cartList     = (new Cart())->allCartList($request);
        return view('cart.index', compact('cartList', 'page_content',
            'filters', 'columns'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function addToCart(StoreCartRequest $request)
    {
        $commonResponse = new CommonResponse();
        $user_id        = Auth::id();
        try {
            DB::beginTransaction();
            $cartObj            = new Cart();
            $validation_message = $cartObj->cartValidation($request, Auth::id());
            if (!empty($validation_message)) {
                throw ValidationException::withMessages(['product_id' => $validation_message]);
            }
            $cartObj->storeCartData($request, Auth::id());
            $commonResponse->data = CartDetailResource::collection($cartObj->getUserCarts(Auth::id()));
            DB::commit();
            $commonResponse->status_message = __('Cart Added Successfully');
        } catch (\Throwable $throwable) {
            DB::rollBack();
            Log::info('ITEM_ADD_TO_CART_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();

    }


    public function getUserCartProducts($user_id){
        $quantity = (new Cart())->getProductQuantityInUserCart($user_id);
        return view('cart.product_quantity', compact('quantity'));
    }

    public function get_cart()
    {
        $commonResponse = new CommonResponse();
        try {
            $cart                           = (new Cart())->getUserCarts(Auth::id());
            $commonResponse->data           = CartDetailResource::collection($cart);
            $commonResponse->status_message = __('Cart Fetched Successfully');
        } catch (Throwable $throwable) {
            Log::info('API_CART_STORE_FAILED', ['error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

    final public function updateUserCart(Request $request, int $id): JsonResponse
    {

        $commonResponse = new CommonResponse();
        try {
            DB::beginTransaction();
            $cartObj            = new Cart();
            $cart = Cart::query()->findOrFail($id);
            $validation_message = $cartObj->cartUpdateValidation($request, $cart);
            if (!empty($validation_message)) {
                throw ValidationException::withMessages(['product_id' => $validation_message]);
            }
            $wo= $cartObj->updateCartData($request, $cart);
            $commonResponse->data = CartDetailResource::collection($cartObj->getUserCarts(Auth::id()));
            DB::commit();
            $commonResponse->status_message = __('Cart Updated Successfully');
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('API_CART_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }

        return $commonResponse->commonApiResponse();
    }

    final public function delete_cart_data(int $id): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            DB::beginTransaction();
            $cart = Cart::query()->findOrFail($id);
            $cart->delete();
            $commonResponse->data = CartDetailResource::collection((new Cart())->getUserCarts(Auth::id()));
            DB::commit();
            $commonResponse->status_message = __('Cart Deleted Successfully');
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('API_CART_DELETE_FAILED', ['error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }

        return $commonResponse->commonApiResponse();
    }


    public function clear_cart()
    {
        $commonResponse = new CommonResponse();
        try {
            DB::beginTransaction();
            Cart::query()->where('user_id', Auth::id())->delete();
            $commonResponse->data = CartDetailResource::collection((new Cart())->getUserCarts(Auth::id()));
            DB::commit();
            $commonResponse->status_message = __('Cart Cleared Successfully');
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('API_CART_CLEAR_FAILED', ['error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }

        return $commonResponse->commonApiResponse();
    }


}
