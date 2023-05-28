<?php

namespace App\Services;

use App\Repositories\Carts\CartsRepository;
use App\Repositories\Products\ProductsRepository;
use App\Service\Interface\ProductsServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductService implements ProductsServiceInterface
{
    protected $productRepository;
    protected $cartsRepository;

    public function __construct(ProductsRepository $productRepository, CartsRepository $cartsRepository)
    {
        $this->productRepository = $productRepository;
        $this->cartsRepository = $cartsRepository;
    }
}
