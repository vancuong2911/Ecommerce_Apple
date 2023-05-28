<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Repositories\Products\ProductsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Service\CartsService;

class CartController extends Controller
{
    protected $cartService;
    protected $productsRepository;

    public function __construct(CartsService $cartService, ProductsRepository $productsRepository)
    {
        $this->cartService = $cartService;
        $this->productsRepository = $productsRepository;
    }

    public function index()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }

        $cartData = $this->cartService->getCartData(Auth::user()->id);
        return view("cart", $cartData);
    }

    public function store(Request $request, $id)
    {
        return $this->cartService->store($request, $id);
    }

    public function destroy($id)
    {
        return $this->cartService->destroy($id);
    }

    public function checkout($total)
    {
        return view("checkout", compact('total'));
    }
    public function buyNow($id)
    {
        // Carts: các sản phẩm được cho vào giỏ hàng
        $carts = $this->cartService->getCartData(Auth::user()->id);
        dd($carts);
        // Product: sản phẩm vừa được click vào buy now
        $product = $this->productsRepository->showOneProductRate($id)->toArray();

        // Đưa sản phẩm vào cart
        dd(array_merge($carts, $product));

        return view("cart", $carts);
    }
}
