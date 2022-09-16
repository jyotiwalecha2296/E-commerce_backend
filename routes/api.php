<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace("App\Http\Controllers\API")->group(function(){

    Route::post('navigation-header','NavigationController@header')->name('header');
    Route::get('home-page','NavigationController@homePage')->name('homepage');
    Route::post('register','RegisterController@register')->name('register');
    Route::post('login','RegisterController@login')->name('login');
    Route::post('password/forgot-password','RegisterController@sendResetLinkResponse')->name('passwords.sent');
    Route::post('password/reset','RegisterController@sendResetResponse')->name('password.reset');
    Route::get('/redirect', 'RegisterController@redirectToProvider');
    Route::get('/callback', 'RegisterController@handleProviderCallback');
    Route::get('country-code', 'RegisterController@getCountryCode');

    //Homepage API
    Route::get('homepage','HomeController@index')->name('home-page');
    Route::get('watches-page','HomeController@watchePages')->name('watche-pages');
    Route::get('global-data','HomeController@globalData')->name('global-data');
    Route::get('featured-products','HomeController@featured_products')->name('featured-products');
    Route::get('home-slider','HomeController@home_slider')->name('home-slider');
    Route::post('newsletter-subscription','HomeController@newsletter_subscription')->name('newsletter-subscription');

    //Pages API
    Route::get('privacy-policy','PagesController@privacyPolicy')->name('privacy-policy');
    Route::get('terms-and-conditions','PagesController@termsAndConditions')->name('terms-and-conditions');
    Route::get('cookies','PagesController@cookies')->name('cookies');    
    Route::post('contact-us','PagesController@contactus')->name('contact-us');
     
    //collection's API
    Route::get('collections','CollectionController@collections')->name('collections');
    Route::get('all-collections-products','CollectionController@all_collections_products')->name('all-collections-products');
    Route::post('collection-products','CollectionController@collectionproducts')->name('collection-products');

    //product page
    Route::post('product-detail','ProductController@product_detail')->name('product-detail');
    Route::post('related-products','ProductController@related_products')->name('related-products');
    Route::post('product-queries','ProductController@product_queries')->name('product_queries');

    //search API
    Route::get('recommended-products-list','ProductController@recommendedProduct')->name('recommendedProduct');
    Route::post('search-product','SearchController@searchProduct')->name('search_product');
    Route::post('search-product-type','SearchController@searchProductType')->name('search_product_type');
    
});

//Authenticated API
Route::namespace("App\Http\Controllers\API")->middleware('auth:api')->group(function(){

    // Address Api
    Route::post('add-address','AddressController@addAddress')->name('addAddress');
    Route::post('update-address','AddressController@updateAddress')->name('updateAddress');
    Route::post('delete-address','AddressController@deleteAddress')->name('deleteAddress');
    Route::post('address-list','AddressController@addressList')->name('addressList');
    Route::post('view-address','AddressController@viewAddress')->name('viewAddress');
    
    //Coupon Api
    Route::post('coupon-list','OrderController@couponList')->name('couponList');
    Route::post('view-coupon','OrderController@viewCoupon')->name('viewCoupon');
    Route::post('apply-coupon','OrderController@applyCoupon')->name('applyCoupon');

    // Gift-Voucher Api
    Route::post('voucher-list','VoucherController@voucherList')->name('voucherList');
    Route::post('view-voucher','VoucherController@viewVoucher')->name('ViewVoucher');
    Route::post('purchase-voucher','VoucherController@purchaseVoucher')->name('purchaseVoucher');
    Route::post('send-voucher','VoucherController@sendVoucher')->name('sendVoucher');
    Route::get('my-purchased-voucher','VoucherController@purchasedVoucher')->name('purchasedVoucher');
    Route::get('voucher-send-list','VoucherController@sendVoucherList')->name('sendVoucherList');
    Route::get('voucher-received-list','VoucherController@receivedVoucherList')->name('receivedVoucherList');
    Route::post('apply-voucher','VoucherController@applyVoucher')->name('applyVoucher');

    //Profile Api
    Route::post('my-account','ProfileController@myAccount')->name('myAccount');
    Route::post('update-profile','ProfileController@updateProfile')->name('updateProfile');
    Route::post('search','ProfileController@searchUser')->name('searchUser');
    Route::post('delete-profile','ProfileController@deleteProfile')->name('deleteProfile');
    Route::post('view-profile','ProfileController@viewProfile')->name('viewProfile');
    Route::post('change-password','ProfileController@changePassword')->name('changePassword');
    Route::post('logout','ProfileController@logout')->name('logout');

    //Order API
    Route::post('add-order','OrderController@addOrder')->name('add_order');
    Route::post('view-order','OrderController@viewOrder')->name('view_order');
    Route::post('order-list','OrderController@orderList')->name('order_list');
    
    //collection products
    Route::post('collection-products-auth','CollectionController@collectionProductsAuth')->name('collection-products-auth');
    
    //products detail API
    Route::post('product-detail-auth','ProductController@productDetailAuth')->name('product-detail-auth');
    
    //RELATED PRODUCTS
    Route::post('related-products-auth','ProductController@relatedProductsAuth')->name('related-products-auth');


    //Wishlist
    Route::post('wishlist','WishlistController@wishlist')->name('wishlist');
    Route::post('view-wishlist','WishlistController@viewWishlist')->name('view-wishlist');
    Route::post('sync-wishlist','WishlistController@syncWishlist')->name('sync-wishlist');

    //Cart
    Route::post('cart','CartController@cart')->name('wishlist');
    Route::post('view-cart','CartController@viewCart')->name('view-cart');
    Route::post('update-cart','CartController@updateCart')->name('update-cart');
    Route::post('delete-cart','CartController@deleteCart')->name('delete-cart');
});