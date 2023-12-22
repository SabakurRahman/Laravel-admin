<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientLogoController;
use App\Http\Controllers\EstimateCategoryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OurApproachController;
use App\Http\Controllers\OurApproachCategoryController;
use App\Http\Controllers\OurProjectController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PhotoGallerieController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UnitPriceController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WebContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\Api;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'visitor_information'], static function () {

    Route::post('register', [ApiAuthController::class, 'registration']);
    Route::post('login', [ApiAuthController::class, 'login']);

    Route::get('banner', [BannerController::class, 'getBannerList']);
    Route::get('blog-category', [BlogCategoryController::class, 'getCategories']);
    Route::post('blog-comment/{blog_id}', [BlogCommentController::class, 'postBlogComment']);
    Route::get('blog', [BlogPostController::class, 'getBlog']);
    Route::get('get-blog', [BlogPostController::class, 'getBlogforFrontend']);
    Route::get('blog-comments/{blog_id}', [BlogCommentController::class, 'getBlogComments']);
    Route::get('blog-with-category', [BlogPostController::class, 'getBlogWithCategory']);

    Route::get('faq', [FaqController::class, 'getFaq']);
    Route::get('team', [TeamController::class, 'getTeam']);
    Route::get('blog/{slug}', [BlogPostController::class, 'getBlogBySlug']);
    Route::get('related-blog', [BlogPostController::class, 'getRelatedBlog']);
    Route::get('blog-with-category', [BlogPostController::class, 'getBlogWithCategory']);

    Route::get('category', [CategoryController::class, 'getCategories']);
    Route::get('sub-category', [CategoryController::class, 'getSubCategories']);
    Route::get('all-product-by-category-slug/{slug}', [CategoryController::class, 'getAllProductListByCategorySlug']);
    //Route::get('all-product-by-category-slug', [CategoryController::class, 'getAllProductListByCategorySlug']);
    Route::get('get-product-with-limit-by-all-category', [CategoryController::class, 'getProductWithLimitByAllCategory']);

    Route::get('client-logo', [ClientLogoController::class, 'getClientLogoList']);

    Route::get('faq', [FaqController::class, 'getFaq']);

    Route::get('newsletter', [NewsLetterController::class, 'getNewsletterList']);
    Route::post('newsletter-store', [NewsLetterController::class, 'PostNewsletterStore']);
    Route::get('photo-gallery', [PhotoGallerieController::class, 'getPhotoGalleryList']);
    Route::get('banner', [BannerController::class, 'getBannerList']);
    Route::get('approach-category', [OurApproachCategoryController::class, 'getOurApproachCategoryList']);
    Route::get('get-approach/{slug}', [OurApproachController::class, 'getOurApproach']);
    Route::get('get-our-project/{slug}', [OurProjectController::class, 'getOurProjects']);
    Route::get('get-all-our-project-details', [OurProjectController::class, 'getAllOurProjectDetails']);
    Route::get('get-our-project-category', [ProjectCategoryController::class, 'getOurProjectCategoryList']);
    // Route::get('get-our-project-details/{slug}', [OurProjectController::class, 'getOurProjectDetails']);
    Route::get('get-single-project-by-all-category', [ProjectCategoryController::class, 'getSingleProjectByAllCategory']);
    Route::get('get-project-with-limit-by-all-category', [ProjectCategoryController::class, 'getProjectWithLimitByAllCategory']);


    Route::get('get-our-project-details/{slug}', [OurProjectController::class, 'getOurProjectDetails']);
    Route::get('get-all-approach', [OurApproachController::class, 'getAllApproach']);
    Route::get('get-our-project-details/{slug}', [OurProjectController::class, 'getOurProjectDetails']);
    //  Route::get('get-all-approach', [OurApproachController::class, 'getAllApproach']);
    Route::post('estimate_project', [UnitPriceController::class, 'getUnitPriceData']);


    Route::get('get-all-approach', [OurApproachController::class, 'getAllApproach']);
    Route::get('get-approach/{slug}', [OurApproachController::class, 'getOurApproach']);
    Route::get('get-our-project/{slug}', [OurProjectController::class, 'getOurProjects']);
    Route::get('get-our-project-details/{slug}', [OurProjectController::class, 'getOurProjectDetails']);

    Route::get('approach-category', [OurApproachCategoryController::class, 'getOurApproachCategoryList']);
    Route::get('get-single-approach-by-all-category', [OurApproachCategoryController::class, 'getSingleApproachByAllCategory']);
    Route::get('estimate-sub-category-type-wise', [EstimateCategoryController::class, 'getAllSubCategoryByTypeAndCategory']);

    Route::get('payment-method', [PaymentMethodController::class, 'getPaymentMethods']);
    Route::get('photo-gallery', [PhotoGallerieController::class, 'getPhotoGalleryList']);


    Route::post('estimate_price', [UnitPriceController::class, 'PostUnitPriceData']);

    Route::get('get-web-content', [WebContentController::class, 'getWebContent']);


    Route::get('social-media', [SocialMediaController::class, 'getSocialMediaList']);

    Route::get('team', [TeamController::class, 'getTeam']);

    Route::post('estimate_project', [UnitPriceController::class, 'getUnitPriceData']);


    Route::get('get-product', [ProductController::class, 'getProductList']);
    Route::get('product-with-filter', [ProductController::class, 'getProductWithFilter']);
    Route::get('get-product-by-slug', [ProductController::class, 'getProductBySlug']);
    Route::get('product-details/{slug}', [ProductController::class, 'getProductDetail']);
//    Route::get('product-details', [ProductController::class, 'getProductDetail']);

    Route::post('estimate_price', [UnitPriceController::class, 'PostUnitPriceData']);

    Route::post('single_estimate_price', [UnitPriceController::class, 'PostUnitPriceDataForSingle']);
    Route::post('multiple_estimate_price', [UnitPriceController::class, 'PostUnitPriceDataForMultiple']);
    Route::post('estimation_leads', [UnitPriceController::class, 'PostEstimationLeads']);

    Route::get('all-location', [LocationController::class, 'index']);

    Route::post('user-profile/{user_id?}', [UserProfileController::class, 'updateOrCreateProfile']);
    // Route::match(['put', 'post'], 'user-profile/{user_id?}', [UserProfileController::class, 'updateOrCreateProfile']);
    // Route::match(['put', 'post'], '/user-profile/{id?}', [UserProfileController::class, 'storeOrUpdateProfile'])->name('products.storeOrUpdate');

    Route::group(['middleware' => 'auth:sanctum'], static function () {
        Route::post('logout', [ApiAuthController::class, 'logout']);
        Route::post('add-to-cart', [CartController::class, 'addToCart']);
        Route::post('order-place', [OrderController::class, 'order_place']);
        Route::get('my-orders', [OrderController::class, 'my_orders']);
        Route::get('order-details/{invoice_no}', [OrderController::class, 'order_details']);


        Route::post('cart', [CartController::class, 'addToCart']);
        Route::get('cart', [CartController::class, 'get_cart']);
        Route::put('cart/{id}', [CartController::class, 'updateUserCart']);
        Route::delete('cart/{id}', [CartController::class, 'delete_cart_data']);
        Route::delete('clear-cart', [CartController::class, 'clear_cart']);
       // Route::apiResource('/place-order', OrderController::class);
        Route::post('/address', [AddressController::class, 'store']);
        Route::put('/address/{address}', [AddressController::class, 'update_my_address']);
        Route::delete('/address/{address}', [AddressController::class, 'destroy']);
        Route::get('/all-addresses', [AddressController::class, 'all_addresses']);
        Route::put('make-address-default/{address}', [AddressController::class, 'make_address_default']);
    });

});







