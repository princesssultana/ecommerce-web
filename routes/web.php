<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Frontend\HomeController as WebsiteHomeController;
use App\Http\Controllers\Frontend\WebProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\WebCategoryController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\Frontend\WebInvoiceController;
use App\Http\Controllers\InvoiceController;

//website routes
Route::get('/',[WebsiteHomeController::class, 'home'])->name('website.home');

Route::get('/ecommerce/register',[AuthController::class,'showRegister'])->name('show.register');
Route::post('/ecommerce/registersubmit',[AuthController::class,'submitRegister'])->name('submit.register');
Route::get('/ecommerce/login',[AuthController::class,'showLogin'])->name('show.login');
Route::post('/ecommerce/loginsubmit',[AuthController::class,'loginSubmit'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/ecommerce/categories', [WebCategoryController::class, 'index'])->name('categories.list');
Route::get('/ecommerce/category/products/{id}', [WebCategoryController::class, 'show'])->name('products.byCategory');

Route::get('/ecommerce/productslist', [WebProductController::class, 'index'])->name('products.list');
Route::get('/ecommerce/product/details/{id}', [WebProductController::class, 'details'])->name('product.details');





Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

Route::match(['get', 'post'], '/checkout/payment/fail', [CheckoutController::class, 'paymentFail'])->name('checkout.fail');
    Route::match(['get', 'post'], '/checkout/payment/cancel', [CheckoutController::class, 'paymentCancel'])->name('checkout.cancel');
    Route::get('/order/confirmation/{id}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');
      Route::match(['get', 'post'], '/checkout/payment/success', [CheckoutController::class, 'paymentSuccess'])->name('checkout.success');    
   
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
 
    
});


//admin panel routes
Route::group(['prefix' => 'admin'], function () {
Route::get('/', [HomeController ::class, 'home'])->name('home');
Route::resource('category', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('customers', CustomerController::class);
Route::get('/order/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
Route::get('/order/invoice/download/{id}', [InvoiceController::class, 'downloadInvoice'])->name('invoice.download');
});

Route::get('/users/index',[UserController::class, 'index'])->name('users.index');
Route::get('/users/show/{id}',[UserController::class, 'show'])->name('users.show');

Route::get('/report',[ReportController::class, 'report'])->name('report'); 

Route::get('/settings',[SettingsController::class, 'settings'])->name('settings');

// SSLCOMMERZ Start


Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END