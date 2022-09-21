    <?php
  
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
  
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
  
/*------------------------------------------
--------------------------------------------
All Login Routes List
--------------------------------------------
--------------------------------------------*/  


Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login')->uses('App\Http\Controllers\Auth\LoginController@login')->name('login.attempt');
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout.attempt');
Route::get('account/verify/{token}', 'App\Http\Controllers\Auth\LoginController@verifyAccount')->name('user.verify');

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/

Route::namespace("App\Http\Controllers\Admin")->middleware(['auth', 'user-access:admin'])->group(function () {
    /*------------------------------------------
                All Admin Routes List
    --------------------------------------------*/
    Route::get('/dashboard', [AdminController::class, 'adminHome'])->name('dashboard');
    Route::resource('/pages', PagesController::class);
    Route::resource('/settings', SettingsController::class);    
    Route::resource('/collections', CollectionController::class);
    Route::resource('/inquiries',InquiryController::class);
    Route::resource('/product-queries', ProductqueriesController::class);    
    Route::resource('/videos', VideoController::class);
    Route::any('search-videos','VideoController@search');
    Route::resource('/coupons', CouponController::class);
    Route::resource('/gift-vouchers', GiftVoucherController::class);
    Route::resource('/shipping', ShippingController::class);
    Route::resource('/orders',OrderController::class);
    Route::resource('/users',UserController::class);
    
    Route::get('/show-orders/{id}', 'OrderController@show')->name('orders.show');


    Route::get('/products', 'ProductController@index')->name('products.index');
    Route::get('/products/all', 'ProductController@index');
    Route::get('/products/create', 'ProductController@create');
    Route::post('/save_product', 'ProductController@saveproduct');
    Route::get('/products/{id}/edit', 'ProductController@edit');
    Route::get('/products/{id}', 'ProductController@show')->name('products.show');
    Route::post('/update_product', 'ProductController@update');
    Route::post('/check-product', 'ProductController@checkSlug'); 
    Route::delete('/products/{id}','ProductController@deleteproduct')->name('products.destroy');
    Route::post('/add-featured-product','ProductController@addfeatured')->name('add.featured.product');
    Route::post('/update-featured-position','ProductController@updatefeaturedposition')->name('update.featured.position');
    Route::get('/remove-featured-product/{id}','ProductController@removefeatured')->name('remove.featured.product'); 
    Route::get('/product-filter/{q}','ProductController@productFilter')->name('product.filter');
   // Route::post('/product-filter','ProductController@productFilter')->name('product.filter'); 


    Route::resource('/subscribed-users', SubscribedusersController::class);  
    /*------------------------------------------
                End Admin Routes List
    --------------------------------------------*/

    Route::get('/profile', 'ProfileController@index')->name('admin.profile');
    Route::post('/update-profile', 'ProfileController@updateProfile');
    Route::post('/update-order-status','OrderController@updateOrderStatus')->name('update.order.status');
    
    //Navigation
    Route::get('/menus','MenuController@index');
    Route::get('/add-menu/{id}','MenuController@create');      
    Route::post('store-menu','MenuController@store');
    Route::get('/edit-menu/{id}','MenuController@edit');
    Route::post('update-menu','MenuController@update'); 
    Route::post('delete-menu','MenuController@delete'); 
    Route::post('menu-sortable','MenuController@sort'); 
    

    //===========Homepage dynamic section======================/
    //slider
    Route::resource('/home-slider', HomesliderController::class);

    Route::get('/homepage-settings ','HomepageController@index');

   
    Route::post('update-homepage-sections','HomepageController@update');
 
    Route::get('orders/invoice/{id}', 'InvoiceController@invoice');

    Route::get('/watch-page','WatchPageController@index');
    Route::post('update-watch-page','WatchPageController@update');
 
});
