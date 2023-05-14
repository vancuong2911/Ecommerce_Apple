<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Products\ProductsRepository;

class MenuController extends Controller
{
    protected $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }
    public function menu()
    {
        $products = $this->productsRepository->getMenu();
        return view('menu', compact('products'));
    }
}
