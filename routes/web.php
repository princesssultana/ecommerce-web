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


//website routes
Route::get('/',[WebsiteHomeController::class, 'home'])->name('website.home');
Route::get('/products', [WebProductController::class, 'index'])->name('frontend.products.index');
Route::get('/product/{id}/details', [WebProductController::class, 'show'])->name('frontend.product.show');





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


