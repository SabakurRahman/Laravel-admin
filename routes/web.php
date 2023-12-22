<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ZoneController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BannerSizeController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientLogoController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\EstimateCategoryController;
use App\Http\Controllers\EstimationLeadController;
use App\Http\Controllers\EstimatePackageController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FaqPageController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\OurApproachController;
use App\Http\Controllers\OurApproachCategoryController;
use App\Http\Controllers\OurProjectController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PhotoGallerieController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectPhotoController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitPriceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VisitorInformationController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WebContentController;
use App\Models\Order;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/migration', [BlogCategoryController::class, 'script']);

Route::get('/dashboard', static function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// backend
// Route::get('/adminLogin',[FrontendController::class,'login'])->name('admin.login');

Route::group(['middleware' => 'auth'], static function () {
    Route::resource('activity-log', ActivityLogController::class);
    Route::resource('attribute', AttributeController::class);
    Route::resource('attribute-value', AttributeValueController::class);
    Route::resource('/order',OrderController::class);
    Route::get('/order-cancel/{order_id}',[OrderController::class,'orderCancel'])->name('order.cancel');
    Route::put('/change-order-status/{order_id}',[OrderController::class,'orderStatusChange'])->name('order.status.change');
    Route::put('/change-shipping-status/{order_id}',[OrderController::class,'shippingStatusChange'])->name('shipping.status.change');
    Route::post('/add-order-note/{order_id}',[OrderController::class,'addOrderNote'])->name('add.order.note');
    Route::resource('couriers', CourierController::class);
    Route::resource('division', DivisionController::class);
    Route::resource('city', CityController::class);
    Route::resource('zone', ZoneController::class);

    Route::resource('/banner', BannerController ::class);
    Route::resource('/banner-size', BannerSizeController ::class);
    Route::resource('blog-category', BlogCategoryController::class);
    Route::resource('blog-comment', BlogCommentController::class);
    Route::get('comment/change-status/{id}/{status}', [BlogCommentController::class, 'changeStatus'])->name('comment-status');
    Route::resource('blog-post', BlogPostController::class);

    Route::resource('/category', CategoryController::class);
    Route::resource('/client-logo', ClientLogoController ::class);
    Route::resource('customer-group', CustomerGroupController::class);

    Route::resource('estimate-category', EstimateCategoryController::class);
    Route::get('estimate-sub-category', [EstimateCategoryController::class, 'getAllSubCategory'])->name('estimate-sub-category');
    Route::get('/invoice', [OrderController::class, 'invoice'])->name('invoice');
    // Route::get('estimate-sub-category', [EstimateCategoryController::class, 'createSubCategory'])->name('estimate-sub-category');
    Route::resource('estimation-lead', EstimationLeadController::class);
    Route::resource('estimate-package', EstimatePackageController::class);

    Route::resource('faq', FaqController::class);
    Route::resource('faq-pages', FaqPageController::class);
    Route::get('/', [FrontendController::class, 'index'])->name('front.index');

    Route::resource('/manufacture', ManufactureController ::class);
    // Route::resource('/manufacture', ManufactureController ::class);

    Route::resource('/news-letter', NewsLetterController ::class);

    Route::resource('our-approach', OurApproachController::class);
    Route::resource('our-approach-category', OurApproachCategoryController::class);
    Route::resource('our-project', OurProjectController::class);
    // Route::post('our-projects-update/{id}', [OurProjectController::class, 'update'])->name('projects.update');
    // Route::resource('our-projects', OurProjectController::class);
    // Route::post('our-projects-update/{id}', [OurProjectController::class, 'update'])->name('projects.update');


    Route::resource('/payment-method', PaymentMethodController ::class);
    Route::resource('/photo-gallery', PhotoGallerieController ::class);
    Route::get('/get-product-title/{productId}', 'ProductController@getProductTitle')->name('product.title');
    Route::resource('/product', ProductController ::class);
    // Route::resource('/product', ProductController ::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('project-photo/{projectPhoto}', [ProjectPhotoController::class, 'update'])->name('project-photo.update');
    Route::delete('project-photo/{projectPhoto}', [ProjectPhotoController::class, 'destroy'])->name('project-photo.destroy');
    Route::put('project-photo/{projectPhoto}', [ProjectPhotoController::class, 'update'])->name('project-photo.update');
    Route::delete('project-photo/{projectPhoto}', [ProjectPhotoController::class, 'destroy'])->name('project-photo.destroy');
    Route::resource('project-category', ProjectCategoryController::class);

    Route::resource('/role', RoleController ::class);

    Route::resource('/social', SocialMediaController ::class);

    Route::resource('tag', TagController::class);
    // Route::resource('tag', TagController::class);
    Route::resource('team', TeamController::class);

    Route::resource('unit', UnitController::class);
    Route::resource('unit-price', UnitPriceController::class);
    Route::resource('/user', UserController ::class);
    Route::get('/user-customer-group', [UserController ::class, 'customerGroupAssign'])->name('user-customer.group');
    Route::get('/user-customer-group-edit/{id}', [UserController ::class, 'customerGroupEdit'])->name('user-customer-group-edit');
    Route::put('/user-customer-group-update/{id}', [UserController ::class, 'updateCustomerGroupAssociations'])->name('user-customer-group.update');
    Route::resource('user-profile', UserProfileController::class);

    Route::get('/visitor', [VisitorInformationController::class, 'index'])->name('visitor.index');
    Route::resource('vendor', VendorController::class);

    Route::resource('/warehouses', WarehouseController ::class);
    // Route::resource('/warehouses', WarehouseController ::class);
    Route::resource('/web-content', WebContentController ::class);

    Route::resource('/cart', CartController::class);
    

//    Route::get('get-user-cart/{user_id}',[CartController::class,'getUserCartProducts'])->name('user.cart');




});

require __DIR__ . '/auth.php';
