<?php

namespace App\Services;

use App\Repositories\ProductsRepository;
use App\Service\Interface\ProductsServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductService implements ProductsServiceInterface
{
    private $productRepository;

    public function __construct(ProductsRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getIndexViewData()
    {
        $menu = $this->productRepository->getMenu();
        $iphone = $this->productRepository->getIphoneProducts();
        $apple_watch = $this->productRepository->getAppleWatchProducts();
        $desktop = $this->productRepository->getDesktopProducts();

        if (Auth::user()) {
            $cart_amount = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->count();
        } else {
            $cart_amount = 0;
        }

        $about_us = $this->productRepository->getAboutUs();
        $banners = $this->productRepository->getBanners();
        $rates = $this->productRepository->getRates();

        return compact('menu', 'iphone', 'apple_watch', 'desktop', 'cart_amount', 'about_us', 'banners', 'rates');
    }
}
