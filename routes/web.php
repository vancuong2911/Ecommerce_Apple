<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients\CartController;
use App\Http\Controllers\Clients\MenuController;
use App\Http\Controllers\Clients\ShipmentController;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\RateController;

Route::get("/", [HomeController::class, 'index'])->name("home");

Route::post("/register/confirm", [HomeController::class, 'register'])->name('register/confirm');
Route::get("/redirects", [HomeController::class, 'redirects']);

Route::get('/menu', [MenuController::class, 'menu'])->name('menu');

Route::get('/trace-my-order', [ShipmentController::class, 'trace'])->name('trace-my-order');
Route::get('/my-order', [ShipmentController::class, 'my_order'])->name('my-order');


// ***** Rate *****
Route::get("/rate/{id}", [RateController::class, 'rate'])->name('rate');
Route::post('/store_rate', [RateController::class, 'store_rate'])->name('store_rate');
Route::get("edit/rate/{id}", [RateController::class, 'edit_rate'])->name('edit/rate');
Route::get("delete/rate", [RateController::class, 'delete_rate'])->name('delete/rate');
Route::get("/rate/confirm/{value}", [RateController::class, 'store_rate'])->name('rate.confirm');


// ***** Cart *****
Route::get("/cart", [CartController::class, 'index'])->name('cart');

Route::post('/menu/{product}', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post("coupon/apply", [ShipmentController::class, 'coupon_apply'])->name('coupon/apply');
// CheckOut
Route::post('/checkout/{total}', [CartController::class, 'checkout'])->name('cart.checkout');

// Order
Route::post('/mails/shipped/{total}', [ShipmentController::class, 'place_order'])->name('mails.shipped');
Route::post('/confirm_place_order/{total}', [ShipmentController::class, 'send'])->name('confirm_place_order');

// Contacts
Route::post('/reserve/confirm', [HomeController::class, 'reservation_confirm'])->name('reserve.confirm');

// Trace
Route::post('/trace/confirm', [ShipmentController::class, 'trace_confirm'])->name('trace.confirm');


Route::get('ssl/pay', [BkashController::class, 'ssl']);
Route::get('ssl/pay2', [BkashController::class, 'ssl2']);
