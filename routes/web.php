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

//website routes
Route::get('/',[WebsiteHomeController::class, 'home'])->name('website.home');
Route::get('/products', [WebProductController::class, 'index'])->name('frontend.products.index');
Route::get('/product/{id}/details', [WebProductController::class, 'show'])->name('frontend.product.show');

Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});







//admin panel routes
Route::group(['prefix' => 'admin'], function () {
Route::get('/', [HomeController ::class, 'home'])->name('home');
Route::resource('category', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('customers', CustomerController::class);
});



Route::get('/users/index',[UserController::class, 'index'])->name('users.index');
Route::get('/users/show/{id}',[UserController::class, 'show'])->name('users.show');

Route::get('/report',[ReportController::class, 'report'])->name('report'); 

Route::get('/settings',[SettingsController::class, 'settings'])->name('settings');


