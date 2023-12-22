<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\ProductReviewSummaryResource;
use App\Manager\CommonResponse;
use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductReviewRequest;
use App\Http\Requests\UpdateProductReviewRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreProductReviewRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductReview $productReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductReview $productReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductReviewRequest $request, ProductReview $productReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductReview $productReview)
    {
        //
    }

    public function storeProductReview(Request $request) :JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $commonResponse->data           = (new ProductReview())->productReviewSave($request);
            $commonResponse->status_message = __('Product review post successfully ');
        } catch (\Throwable $throwable) {
            Log::info('PRODUCT_REVIEW_POST_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();


    }

    public function getProductReview(Request $request) : JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $data    = (new ProductReview())->productReviewRetrive($request);
            $review  = ProductReviewResource::collection($data['reviews']);

            $responseData = [
                'score'       => $data['score'],
                 'stars'      => $data['stars'],
                 'total_like' => $data['like_count'],
                 'reviews'    => $review,
            ];
            $commonResponse->data = $responseData;

            $commonResponse->status_message = __('Product review get successfully');
        } catch (\Throwable $throwable) {
            Log::info('PRODUCT_REVIEW_POST_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();


    }
}
