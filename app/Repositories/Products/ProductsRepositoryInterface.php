<?php

namespace App\Repositories\Products;

interface ProductsRepositoryInterface
{
    public function getMenu();

    public function getIphoneProducts();

    public function getAppleWatchProducts();

    public function getDesktopProducts();

    public function getAboutUs();

    public function getBanners();

    public function getRates();
}
