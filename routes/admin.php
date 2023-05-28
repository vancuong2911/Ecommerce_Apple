<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\Admins\Banners\BannersController;
use App\Http\Controllers\Admins\Coupons\CouponsController;
use App\Http\Controllers\Admins\Orders\OrdersController;
use App\Http\Controllers\Admins\Products\ProductController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\Admins\Customize\CustomizeController;
use App\Http\Controllers\Admins\ListAdmins\ListAdminController;
use App\Http\Controllers\Admins\Customers\CustomersController;
use App\Http\Controllers\Admins\Charges\ChargesController;
use App\Http\Controllers\Admins\DeliveryBoys\DeliveryBoysController;

// Admin start Route
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['admin:1,2'])->group(function () {
    // Home Admin
    Route::get('/admin/home', [HomeAdminController::class, 'index'])->name('/admin/home');

    Route::controller(ProductController::class)->group(function () {
        // List Product
        Route::get('/admin/products', 'index')->name('/admin/products');
        // Add product
        Route::get('/add/product', 'add_product')->name('/add/product');
        Route::post('/product/add/process', 'product_add_process')->name('/product/add/process');
        // Edit product
        Route::get('/product/edit/{id}', 'product_edit')->name('/product/edit');
        Route::post('/product/edit/process/{id}', 'product_edit_process')->name('/product/edit/process');
        // Delete product
        Route::get('/product/delete/{id}', 'product_delete_process')->name('/product/delete');
    });

    // Orders
    Route::controller(OrdersController::class)->group(function () {
        //  ---------------------- Pending Orders  ----------------------
        // Show pending orders
        Route::get('/admin/orders-incomplete', 'order_incomplete')->name('/admin/orders-incomplete');
        // Detail invoice
        Route::get('/invoice/details/{id}', 'invoice_details')->name('invoice/details');
        // Detail Customer
        Route::get('/customer', 'user_show')->name('/customer');
        // Approve invoice
        Route::post('/invoice/approve/{id}', 'invoice_approve')->name('/invoice/approve');

        //  ---------------------- Processing Order Details  ----------------------
        // Show processiong order details
        Route::get('/orders/process', 'orders_process')->name('/orders/process');
        // Detail invoice
        // Complete Delivery
        Route::get('/invoice/complete/{id}', 'invoice_complete')->name('invoice/complete');

        //  ---------------------- Complete Orders  ----------------------
        // Show
        Route::get('/orders-complete', 'order_complete')->name('/orders-complete');
        // Detail invoice

        //  ---------------------- Cancelled Order Details  ----------------------
        Route::get('/orders/cancel', 'orders_cancel')->name('/orders/cancel');
        Route::get('/invoice/cancel-order/{id}', 'invoice_cancel')->name('/invoice/cancel-order');
    });

    // Contacts
    Route::get('/admin/contact', [AdminController::class, 'contact'])->name('/admin/contact');

    // Customice Template
    Route::controller(CustomizeController::class)->group(function () {
        //  ---------------------- customize  ----------------------
        // Show customize
        Route::get('/admin/customize', 'customize')->name('/admin/cutomize');
        // Edit customize
        Route::get('/customize/edit', 'customize_edit')->name('/customize/edit');
        Route::post('/customize_edit_process', 'edit_customize_process')->name('/customize_edit_process');
    });

    // Banners
    Route::controller(BannersController::class)->group(function () {
        //  ---------------------- customize  ----------------------
        // Show all banners
        Route::get('/admin/banner/all', 'banner')->name('/admin/banner/all');
        // Add banner
        Route::get('/admin/add/banner', 'banner_add')->name('/admin/add/banner');
        Route::post('/banner/add/process', 'banner_add_process')->name('/banner/add/process');
        // Edit banner
        Route::get('/admin/banner/edit/{id}', 'banner_edit')->name('/admin/banner/edit');
        Route::post('/banner/edit/process/{id}', 'banner_edit_process')->name('/banner/edit/process');
        // Delete banner
        Route::get('/admin/banner/delete/{id}', 'banner_delete_process')->name('/admin/banner/delete');
    });

    // List Admin
    Route::controller(ListAdminController::class)->group(function () {
        // Show all admin
        Route::get('/admin/show', 'admin_show')->name('/admin/show');
        // Add admin
        Route::get('/admin-add', 'add_admin')->name('/admin-add');
        Route::post('/admin-add-process', 'add_admin_process')->name('/admin-add-process');
        // Edit admin
        Route::get('/admin/edit/{id}', 'edit_admin')->name('/admin/edit');
        Route::post('/admin-edit-process/{id}', 'edit_admin_process')->name('/admin-edit-process');
        // Delete admin
        Route::get('/admin/delete/{id}', 'delete_admin')->name('/admin/delete');
    });

    // List Customer
    Route::get('/customer', [CustomersController::class, 'user_show'])->name('/customer');

    // Coupon
    Route::controller(CouponsController::class)->group(function () {
        // Show all coupon
        Route::get('/admin/coupon', 'coupon_show')->name('/admin/coupon');
        // Add coupon
        Route::get('/add/coupon', 'add_coupon')->name('/add/coupon');
        Route::post('/coupon-add-process', 'add_coupon_process')->name('/coupon-add-process');

        Route::get('/admin/coupon/edit/{id}', 'edit_coupon')->name('/admin/coupon/edit');
        Route::post('/coupon-edit-process/{id}', 'edit_coupon_process')->name('/coupon-edit-process');
        // Edit coupon
        // Delete coupon
        Route::get('/admin/coupon/delete/{id}', 'delete_coupon')->name('/admin/coupon/delete');
    });

    // Charge
    Route::controller(ChargesController::class)->group(function () {
        // Show all coupon
        Route::get('/admin/charge', 'charge')->name('/admin/charge');
        // Add coupon
        Route::get('/add/charge', 'add_charge')->name('/add/charge');
        Route::post('/charge-add-process', 'add_charge_process')->name('/charge-add-process');

        // Edit coupon
        Route::get('/admin/charge/edit/{id}', 'edit_charge')->name('/admin/edit/delete');
        Route::post('/charge-edit-process/{id}', 'edit_charge_process')->name('/charge-edit-process');
        // Delete coupon
        Route::get('/admin/charge/delete/{id}', 'delete_charge')->name('/admin/charge/delete');
    });

    // Delivery Boy
    Route::controller(DeliveryBoysController::class)->group(function () {
        Route::get('/delivery-boy', 'delivery_boy')->name('/delivery-boy');
        Route::get('/add/delivery_boy', 'add_delivery_boy')->name('/add/delivery_boy');
        Route::post('/add-delivery-boy-process', 'add_delivery_boy_process')->name('/add-delivery-boy-process');
        Route::get('/delivery_boy/delete/{id}', 'delete_delivery_boy')->name('/delivery_boy/delete');
        Route::get('/delivery_boy/edit/{id}', 'edit_delivery_boy')->name('/delivery_boy/edit');
        Route::post('/edit_delivery_boy_process/{id}', 'edit_delivery_boy_process')->name('/edit_delivery_boy_process');
    });
});
