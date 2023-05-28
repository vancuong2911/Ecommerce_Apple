<?php

namespace App\Repositories\Products;

use App\Repositories\RepositoryInterface;

interface ProductsRepositoryInterface extends RepositoryInterface
{
    public function getProducts();

    public function getCountProducts();

    public function getIphoneProducts();

    public function getAppleWatchProducts();

    public function getDesktopProducts();
}
