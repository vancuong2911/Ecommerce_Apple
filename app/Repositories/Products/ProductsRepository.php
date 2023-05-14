<?php

namespace App\Repositories\Products;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductsRepository
{
    public function getMenu()
    {
        return DB::table('products')->where('active', '0')->get();
    }

    public function getCountProducts()
    {
        return DB::table('products')->count();
    }

    public function getProductbyUserId()
    {
        return DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->get();;
    }

    public function getIphoneProducts()
    {
        return DB::table('products')->where('catagory', 'iphone')->get();
    }

    public function getAppleWatchProducts()
    {
        return DB::table('products')->where('catagory', 'apple watch')->get();
    }

    public function getDesktopProducts()
    {
        return DB::table('products')->where('catagory', 'desktop')->get();
    }

    public function getAboutUs()
    {
        return DB::table('about_us')->get();
    }

    public function getBanners()
    {
        return DB::table('banners')->get();
    }
    // Chuyển sang repository của rates
    public function getRates()
    {
        return DB::table('rates')
            ->join('users', 'rates.user_id', '=', 'users.id')
            ->select('rates.*', 'users.name')
            ->get();
    }

    public function getAllRates()
    {
        return DB::table('rates')->get();
    }
}
