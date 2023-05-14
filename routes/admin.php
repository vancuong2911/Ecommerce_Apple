<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\Admins\Products\ProductController;

// Admin start Route
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('admin')->group(function () {
    Route::get('/admin/home', function () {
        return redirect('redirects');
    })->name('/admin/home');

    Route::controller(ProductController::class)->group(function () {
        Route::get('/admin/products', [ProductController::class, 'index'])->name('/admin/products');

        // Add product
        Route::get('/add/product', [ProductController::class, 'add_product'])->name('/add/product');
        Route::post('/product/add/process', [ProductController::class, 'product_add_process'])->name('/product/add/process');

        // Edit product
        Route::get('/product/edit/{id}', [ProductController::class, 'product_edit'])->name('/product/edit');
        Route::post('/product/edit/process/{id}', [ProductController::class, 'product_edit_process'])->name('/product/edit/process');

        // Delete product
        Route::get('/product/delete/{id}', [ProductController::class, 'product_delete_process'])->name('/product/delete');
    });


    Route::get('/orders/process', [AdminController::class, 'orders_process'])->name('/orders/process');
    Route::get('/orders/cancel', [AdminController::class, 'orders_cancel'])->name('/orders/cancel');



    Route::get('/admin/orders-incomplete', [AdminController::class, 'order_incomplete'])->name('/admin/orders-incomplete');
    Route::get('/orders-complete', [AdminController::class, 'order_complete'])->name('/orders-complete');
    Route::get('/admin/reservation', [AdminController::class, 'reservation'])->name('/admin/reservation');
    Route::get('/admin/coupon', [AdminController::class, 'coupon_show'])->name('/admin/coupon');
    Route::get('/admin/show', [AdminController::class, 'admin_show'])->name('/admin/show');
    Route::get('/customer', [AdminController::class, 'user_show'])->name('/customer');
    Route::get('/admin/charge', [AdminController::class, 'charge'])->name('/admin/charge');
    Route::get('/admin/banner/all', [AdminController::class, 'banner'])->name('/admin/banner/all');
    Route::get('/admin/customize', [AdminController::class, 'customize'])->name('/admin/cutomize');
    Route::get('/admin/add/banner', [AdminController::class, 'banner_add'])->name('/admin/add/banner');




    Route::post('/invoice/approve/{id}', [AdminController::class, 'invoice_approve'])->name('/invoice/approve');
    Route::get('/invoice/details/{id}', [AdminController::class, 'invoice_details'])->name('invoice/details');
    Route::get('/invoice/cancel-order/{id}', [AdminController::class, 'invoice_cancel'])->name('/invoice/cancel-order');


    Route::get('/invoice/complete/{id}', [AdminController::class, 'invoice_complete'])->name('invoice/complete');

    Route::get('/order/location', [AdminController::class, 'order_location'])->name('/order/location');
    Route::post('/invoice/location/edit', [AdminController::class, 'edit_order_location'])->name('/invoice/location/edit');
    Route::get('/delivery-boy', [AdminController::class, 'delivery_boy'])->name('/delivery-boy');


    Route::get('/admin-add', [AdminController::class, 'add_admin'])->name('/admin-add');
    Route::get('/add/delivery_boy', [AdminController::class, 'add_delivery_boy'])->name('/add/delivery_boy');
    Route::post('/admin-add-process', [AdminController::class, 'add_admin_process'])->name('/admin-add-process');
    Route::get('/admin/delete/{id}', [AdminController::class, 'delete_admin'])->name('/admin/delete');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit_admin'])->name('/admin/edit');
    Route::post('/admin-edit-process/{id}', [AdminController::class, 'edit_admin_process'])->name('/admin-edit-process');
    Route::post('/add-delivery-boy-process', [AdminController::class, 'add_delivery_boy_process'])->name('/add-delivery-boy-process');
    Route::get('/delivery_boy/delete/{id}', [AdminController::class, 'delete_delivery_boy'])->name('/delivery_boy/delete');
    Route::get('/delivery_boy/edit/{id}', [AdminController::class, 'edit_delivery_boy'])->name('/delivery_boy/edit');
    Route::post('/edit_delivery_boy_process/{id}', [AdminController::class, 'edit_delivery_boy_process'])->name('/edit_delivery_boy_process');
    Route::post('/banner/add/process', [AdminController::class, 'banner_add_process'])->name('/banner/add/process');
    Route::get('/admin/banner/edit/{id}', [AdminController::class, 'banner_edit'])->name('/admin/banner/edit');
    Route::post('/banner/edit/process/{id}', [AdminController::class, 'banner_edit_process'])->name('/banner/edit/process');
    Route::get('/admin/banner/delete/{id}', [AdminController::class, 'banner_delete_process'])->name('/admin/banner/delete');
    Route::get('/add/coupon', [AdminController::class, 'add_coupon'])->name('/add/coupon');
    Route::post('/coupon-add-process', [AdminController::class, 'add_coupon_process'])->name('/coupon-add-process');
    Route::get('/admin/coupon/delete/{id}', [AdminController::class, 'delete_coupon'])->name('/admin/coupon/delete');
    Route::get('/admin/coupon/edit/{id}', [AdminController::class, 'edit_coupon'])->name('/admin/coupon/edit');
    Route::post('/coupon-edit-process/{id}', [AdminController::class, 'edit_coupon_process'])->name('/coupon-edit-process');
    Route::get('/add/charge', [AdminController::class, 'add_charge'])->name('/add/charge');
    Route::post('/charge-add-process', [AdminController::class, 'add_charge_process'])->name('/charge-add-process');
    Route::get('/admin/charge/delete/{id}', [AdminController::class, 'delete_charge'])->name('/admin/charge/delete');
    Route::get('/admin/charge/edit/{id}', [AdminController::class, 'edit_charge'])->name('/admin/edit/delete');
    Route::post('/charge-edit-process/{id}', [AdminController::class, 'edit_charge_process'])->name('/charge-edit-process');
    Route::get('/customize/edit', [AdminController::class, 'customize_edit'])->name('/customize/edit');
    Route::post('/customize_edit_process', [AdminController::class, 'edit_customize_process'])->name('/customize_edit_process');
});
