<?php

namespace App\Repositories\Products;

use Illuminate\Support\Facades\DB;

class ProductsRepository
{
    public function getMenu()
    {
        return DB::table('products')->where('active', '0')->get();
    }

    public function getIphoneProducts()
    {
        return DB::table('products')->where('catagory', 'iphone')->where('session', 0)->get();
    }

    public function getAppleWatchProducts()
    {
        return DB::table('products')->where('catagory', 'apple watch')->where('session', 1)->get();
    }

    public function getDesktopProducts()
    {
        return DB::table('products')->where('catagory', 'desktop')->where('session', 2)->get();
    }

    public function getAboutUs()
    {
        return DB::table('about_us')->get();
    }

    public function getBanners()
    {
        return DB::table('banners')->get();
    }

    public function getRates()
    {
        return DB::table('rates')
            ->join('users', 'rates.user_id', '=', 'users.id')
            ->select('rates.*', 'users.name')
            ->get();
    }
}
