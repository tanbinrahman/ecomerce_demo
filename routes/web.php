<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductReviewController;

use App\Http\Controllers\Front\FrontController;

// use Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Front Controller
Route::get('/',[FrontController::class,'index']);
Route::get('/product/{slug}',[FrontController::class,'product']);
Route::post('add_to_cart',[FrontController::class,'add_to_cart']);
Route::get('/cart',[FrontController::class,'cart']);
Route::get('/category/{slug}',[FrontController::class,'category']);
Route::get('/search/{str}',[FrontController::class,'search']);
Route::get('/registration',[FrontController::class,'registration']);
Route::post('/registration_process',[FrontController::class,'registration_process'])->name('registration.registration_process');
Route::post('/login_process',[FrontController::class,'login_process'])->name('login.login_process');
Route::get('/CheckOut',[FrontController::class,'CheckOut']);
Route::post('/apply_coupon_code',[FrontController::class,'apply_coupon_code']);
Route::post('/remove_coupon_code',[FrontController::class,'remove_coupon_code']);
Route::post('/place_order',[FrontController::class,'place_order']);
Route::get('/order_placed',[FrontController::class,'order_placed']);
Route::get('/order_fail',[FrontController::class,'order_fail']);
Route::get('/instamojo_payment_redirect',[FrontController::class,'instamojo_payment_redirect']);
Route::get('/verification/{id}',[FrontController::class,'email_verification']);
Route::post('/forgot_password',[FrontController::class,'forgot_password']);
Route::get('/forgot_password_change/{id}',[FrontController::class,'forgot_password_change']);
Route::post('/forgot_password_change_process',[FrontController::class,'forgot_password_change_process']);
Route::post('/product_review_process',[FrontController::class,'product_review_process']);



Route::group(['middleware'=>'user_auth'],function(){
    Route::get('/order',[FrontController::class,'order']);
    Route::get('/order_detail/{id}',[FrontController::class,'order_detail']);
});


Route::get('/logout', function () {
    session()->forget('FRONT_USER_LOGIN');
    session()->forget('FRONT_USER_ID');
    session()->forget('FRONT_USER_NAME');
    return redirect('/');
});




Route::get('admin',[AdminController::class,'index']);
Route::post('admin/auth',[AdminController::class,'auth'])->name('admin.auth');

Route::group(['middleware'=>'admin_auth'],function(){
    // category controller
    Route::get('admin/dashboard',[AdminController::class,'dashboard']);
    Route::get('admin/category',[CategoryController::class,'index'])->name('admin.category');
    Route::get('admin/category/manage_catagory',[CategoryController::class,'manage_catagory'])->name('category.manage_catagory');
    Route::get('admin/category/manage_catagory/{id}',[CategoryController::class,'manage_catagory']);
    Route::post('admin/category/manage_catagory_process',[CategoryController::class,'manage_catagory_process'])->name('category.manage_catagory_process');
    Route::get('admin/category/delete/{id}',[CategoryController::class,'delete']);
    // Route::get('admin/category/edit/{id}',[CategoryController::class,'edit'])->name('category.edit'); 
    // Route::post('admin/category/update/{id}',[CategoryController::class,'update'])->name('category.update');
    Route::get('admin/category/status/{status}/{id}',[CategoryController::class,'status']);
    
    // coupon controller
    Route::get('admin/coupon',[CouponController::class,'index'])->name('admin.coupon');
    Route::get('admin/coupon/manage_coupon',[CouponController::class,'manage_coupon'])->name('coupon.manage_coupon');
    Route::get('admin/coupon/manage_coupon/{id}',[CouponController::class,'manage_coupon']);
    Route::post('admin/coupon/manage_coupon_process',[CouponController::class,'manage_coupon_process'])->name('coupon.manage_coupon_process');
    Route::get('admin/coupon/delete/{id}',[CouponController::class,'delete'])->name('coupon.delete');
    // Route::get('admin/coupon/edit/{id}',[CouponController::class,'edit'])->name('coupon.edit');
    // Route::post('admin/coupon/update/{id}',[CouponController::class,'update'])->name('coupon.update');
    Route::get('admin/coupon/status/{status}/{id}',[CouponController::class,'status']);
   
    // size controller
    Route::get('admin/size',[SizeController::class,'index'])->name('admin.size');
    Route::get('admin/size/manage_size',[SizeController::class,'manage_size'])->name('size.manage_size');
    Route::post('admin/size/manage_size_process',[SizeController::class,'manage_size_process'])->name('size.insert');
    Route::get('admin/size/delete/{id}',[SizeController::class,'delete'])->name('size.delete');
    Route::get('admin/size/edit/{id}',[SizeController::class,'edit'])->name('size.edit');
    Route::post('admin/size/update/{id}',[SizeController::class,'update'])->name('size.update');
    Route::get('admin/size/status/{status}/{id}',[SizeController::class,'status']);
    
    // Color controller
    Route::get('admin/color',[ColorController::class,'index'])->name('admin.color');
    Route::get('admin/color/manage_color',[ColorController::class,'manage_color'])->name('color.manage_color');
    Route::post('admin/color/manage_color_process',[ColorController::class,'manage_color_process'])->name('color.insert');
    Route::get('admin/color/delete/{id}',[ColorController::class,'delete'])->name('color.delete');
    Route::get('admin/color/edit/{id}',[ColorController::class,'edit'])->name('color.edit');
    Route::post('admin/color/update/{id}',[ColorController::class,'update'])->name('color.update');
    Route::get('admin/color/status/{status}/{id}',[ColorController::class,'status']);
    
    // Product Controller
    Route::get('admin/product',[ProductController::class,'index'])->name('admin.product');
    Route::get('admin/product/manage_product',[ProductController::class,'manage_product'])->name('product.manage_product');
    Route::get('admin/product/manage_product/{id}',[ProductController::class,'manage_product']);
    Route::post('admin/product/manage_product_process',[ProductController::class,'manage_product_process'])->name('product.manage_product_process');
    Route::get('admin/product/delete/{id}',[ProductController::class,'delete'])->name('product.delete');
    // Route::get('admin/product/edit/{id}',[ProductController::class,'edit'])->name('product.edit');
    // Route::post('admin/product/update/{id}',[ProductController::class,'update'])->name('product.update');
    Route::get('admin/product/status/{status}/{id}',[ProductController::class,'status']);
    Route::get('admin/product/product_attr_delete/{paid}/{pid}',[ProductController::class,'product_attr_delete']);
    Route::get('admin/product/product_images_delete/{paid}/{pid}',[ProductController::class,'product_images_delete']);


    // Brand Controller
    Route::get('admin/brand',[BrandController::class,'index'])->name('admin.brand');
    Route::get('admin/brand/manage_brand',[BrandController::class,'manage_brand'])->name('brand.manage_brand');
    Route::get('admin/brand/manage_brand/{id}',[BrandController::class,'manage_brand']);
    Route::post('admin/brand/manage_brand_process',[BrandController::class,'manage_brand_process'])->name('brand.manage_brand_process');
    Route::get('admin/brand/delete/{id}',[BrandController::class,'delete']);
    Route::get('admin/brand/status/{status}/{id}',[BrandController::class,'status']);

    // tax controller
    Route::get('admin/tax',[TaxController::class,'index'])->name('admin.tax');
    Route::get('admin/tax/manage_tax',[TaxController::class,'manage_tax'])->name('tax.manage_tax');
    Route::get('admin/tax/manage_tax/{id}',[TaxController::class,'manage_tax']);
    Route::post('admin/tax/manage_tax_process',[TaxController::class,'manage_tax_process'])->name('tax.manage_tax_process');
    Route::get('admin/tax/delete/{id}',[TaxController::class,'delete']);
    Route::get('admin/tax/status/{status}/{id}',[TaxController::class,'status']);

    //Home Banner Controller

    Route::get('admin/home_banner',[HomeBannerController::class,'index'])->name('admin.home_banner');
    Route::get('admin/home_banner/manage_home_banner',[HomeBannerController::class,'manage_home_banner'])->name('home_banner.manage_home_banner');
    Route::get('admin/home_banner/manage_home_banner/{id}',[HomeBannerController::class,'manage_home_banner']);
    Route::post('admin/home_banner/manage_home_banner_process',[HomeBannerController::class,'manage_home_banner_process'])->name('home_banner.manage_home_banner_process');
    Route::get('admin/home_banner/delete/{id}',[HomeBannerController::class,'delete']);
    Route::get('admin/home_banner/status/{status}/{id}',[HomeBannerController::class,'status']);

    // Customer controller
    Route::get('admin/customer',[CustomerController::class,'index'])->name('admin.customer');
    Route::get('admin/customer/show/{id}',[CustomerController::class,'show']);
    Route::get('admin/customer/status/{status}/{id}',[CustomerController::class,'status']);

    // Order Controller
    Route::get('admin/order',[OrderController::class,'index'])->name('admin.order');
    Route::get('admin/order_details/{id}',[OrderController::class,'order_details']);
    Route::get('admin/update_payment_status/{status}/{id}',[OrderController::class,'update_payment_status']);
    Route::get('admin/update_order_status/{status}/{id}',[OrderController::class,'update_order_status']);
    Route::post('admin/order_details/{id}',[OrderController::class,'update_track_details']);
    
    //Product Review
    Route::get('admin/product_review',[ProductReviewController::class,'product_review'])->name('admin.product_review');
    Route::get('admin/product_review/status/{status}/{id}',[ProductReviewController::class,'status']);
    
    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        // Session::flash('error','Log out successfully');
        session()->flash('error','Log out successfully');
        return redirect('admin');
    });
    
});
//  Route::get('admin/updatepassword',[AdminController::class,'updatepassword']);
