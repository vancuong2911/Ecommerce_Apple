<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Carts\CartsRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Products\ProductsRepository;
use App\Repositories\Users\UsersRepository;
use App\Service\CartsService;
use Illuminate\Support\Facades\DB;

class HomeAdminController extends Controller
{
    protected $productRepository;
    protected $cartService;
    protected $cartRepository;
    protected $userRepository;

    public function __construct(
        ProductsRepository $productRepository,
        CartsService $cartService,
        CartsRepository $cartRepository,
        UsersRepository $userRepository
    ) {
        $this->productRepository = $productRepository;
        $this->cartService = $cartService;
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        if (Auth::check()) {
            // Check login
            $user = Auth::user();
            if ($user->usertype == '1' || $user->usertype == '2') {
                // User is admin
                $data = $this->getAdminData();
                return view('admin.dashboard', $data);
            }
        }
        // User is not admin
        $data = $this->getUserData();
        return view('home', $data);
    }

    public function getAdminData()
    {
        $admin = DB::table('admin')->where('id', Auth::id())->first();

        $pending_order = $this->cartRepository->getPendingOrderCount();
        $processing_order = $this->cartRepository->getProcessingOrderCount();
        $cancel_order = $this->cartRepository->getCancelledOrderCount();
        $complete_order = $this->cartRepository->getCompleteOrderCount();
        $total = $this->cartRepository->getTotal();
        $cash_on_payment = $this->cartRepository->getCashOnDeliveryTotal();
        $customer = $this->userRepository->getUserCount('0');
        $delivery_boy = $this->userRepository->getUserCount('2');
        $user = $this->userRepository->getUserCount(null);
        $admin = $user - ($customer + $delivery_boy);
        $rates = $this->cartRepository->getAllRates();

        $product = array();

        // Khởi tạo ban đầu = 0
        foreach ($rates as $rate) {
            $product[$rate->product_id] = 0;
            $voter[$rate->product_id] = 0;
            $per_rate[$rate->product_id] = 0;
        }

        foreach ($rates as $rate) {
            // Tổng giá trị đánh giá của sản phẩm
            $product[$rate->product_id] = $product[$rate->product_id] + $rate->star_value;

            // Tăng lên 1 để đếm số lượng đánh giá
            $voter[$rate->product_id] = $voter[$rate->product_id] + 1;

            if ($voter[$rate->product_id] > 0) {
                // Lấy đánh giá trung bình
                $per_rate[$rate->product_id] = $product[$rate->product_id] / $voter[$rate->product_id];
            } else {
                // Giá trị đánh giá của hiện tại
                $per_rate[$rate->product_id] = $product[$rate->product_id];
            }

            $per_rate[$rate->product_id] = number_format($per_rate[$rate->product_id], 1);
        }

        if (!empty($per_rate)) {
            // Sắp xếp giảm dần
            $copy_product = $per_rate;
            arsort($per_rate);

            // Tìm thông tin sản phẩm có giá trị đánh giá cao
            $product_get = array();

            foreach ($per_rate as $prod) {
                $index_search = array_search($prod, $copy_product);
                $product_get = DB::table('products')->where('id', $index_search)->get();
            }
        } else {
            $copy_product = [];
            $product_get = [];
        }

        $carts = DB::table('carts')->where('product_order', '!=', 'no')->where('product_order', '!=', 'cancel')->get();
        $cart = array();
        $product_cart = [];

        foreach ($carts as $cart) {
            $product_cart[$cart->product_id] = 0;
        }

        foreach ($carts as $cart) {
            $product_cart[$cart->product_id] = $product_cart[$cart->product_id] + $cart->quantity;
        }

        $copy_cart = $product_cart;
        arsort($product_cart);

        return compact(
            'pending_order',
            'product_cart',
            'copy_cart',
            'total',
            'cash_on_payment',
            'customer',
            'delivery_boy',
            'admin',
            'processing_order',
            'cancel_order',
            'complete_order',
            'rates'
        );
    }

    public function getUserData()
    {
        $menu = $this->productRepository->getProducts();
        $about_us = DB::table('about_us')->get();
        $products = $this->productRepository->getProducts();
        $rates = $this->cartRepository->getRates();

        $iphoneProducts = $this->productRepository->showProductsRate('iphone');
        $appleWatchProducts = $this->productRepository->showProductsRate('apple_watch');
        $desktopProducts = $this->productRepository->showProductsRate('desktop');

        $cart_amount = Auth::user() ? $this->cartRepository->getCartsAmountByUserId(Auth::user()->id) : 0;

        return compact(
            'menu',
            'cart_amount',
            'about_us',
            'products',
            'rates',
            'iphoneProducts',
            'appleWatchProducts',
            'desktopProducts'
        );
    }
}
