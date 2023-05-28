<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\CartsService;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Products\ProductsRepository;
use App\Repositories\Rates\RatesRepository;
use App\Service\RatesService;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    protected $productRepository;
    protected $cartService;
    protected $rateRepository;
    protected $rateService;

    public function __construct(ProductsRepository $productRepository, CartsService $cartService, RatesRepository $rateRepository, RatesService $rateService)
    {
        $this->productRepository = $productRepository;
        $this->cartService = $cartService;
        $this->rateRepository = $rateRepository;
        $this->rateService = $rateService;
    }
    public function menu()
    {
        if (request()->is('menu-hot')) {
            $products = $this->productRepository->getProductsIsHot();
        } else {
            $products = $this->productRepository->getProducts();
        }

        return view('menu', ['products' => $products]);
    }
    public function singleProduct($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }
        $product = $this->productRepository->showOneProductRate($id);
        Session::put('product_id', $id);

        $already_rate = $this->rateRepository->getRateCount($id, $user->id);
        $find_rate = $this->rateRepository->getRateValue($id, $user->id);

        $comments = $this->rateRepository->getComments($id, $user->id);

        if (!$product) {
            abort(404);
        }
        return view('single_product', compact('find_rate', 'already_rate', 'comments', 'product'));
    }
    public function singleProductCheckout(Request $request, $id)
    {
        $this->cartService->store($request, $id);
        $cartData = $this->cartService->getCartData(Auth::user()->id);
        return redirect()->route('cart', ['cartData' => $cartData]);
    }
}
