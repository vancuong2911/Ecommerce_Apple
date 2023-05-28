<?php

namespace App\Service;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Carts\CartsRepository;
use App\Service\Interface\CartsServiceInterface;

class CartsService implements CartsServiceInterface
{

    protected $cartRepository;

    public function __construct(CartsRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function store($request, $id)
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }

        $product = Product::find($id);
        $productId = $product->id;
        $quantity = $request->number;

        if (Cart::where('product_id', '=', $id)->where('user_id', Auth::user()->id)->where('product_order', 'no')->exists()) {
            $quant = $this->cartRepository->getCartQuantity($productId,  Auth::user()->id) ?? 1;

            $quantity = $quantity + (int) $quant;

            $this->cartRepository->updateCartQuantity($id, Auth::user()->id, $quantity, $product->price);
        } else {
            $this->cartRepository->createCart($id, Auth::user()->id, $quantity, $product->price, $product);
        }
        return back()->with('message', 'Add product success');
    }

    public function destroy($id)
    {
        $product = $this->cartRepository->getCartById($id);
        $product->delete();

        return redirect()->route('cart');
    }

    public function getCartData($userId)
    {
        $carts = $this->cartRepository->getCartByUserId($userId)->toArray();
        // dd($carts);

        $cartAmount = $this->cartRepository->getCartsAmountByUserId($userId);

        $couponCode = $this->cartRepository->getCouponCodeByUserId($userId);

        $total_price = $this->cartRepository->getTotalPriceByUserId($userId);

        $without_discount_price = $this->cartRepository->getWithoutDiscountPriceByUserId($userId);

        if ($couponCode != NULL) {
            $couponData = $this->cartRepository->getCouponDataByCode($couponCode);

            $discount_price = $this->cartRepository->couponDiscountPrice($total_price, $couponData);
            $total_price = $total_price - $discount_price;
        } else {
            $discount_price = 0;
        }

        $extra_charge = $this->cartRepository->getExtraCharges();

        $total_extra_charge = $this->cartRepository->getTotalExtraCharge();

        return compact('carts', 'total_price', 'discount_price', 'cartAmount', 'extra_charge', 'total_extra_charge', 'without_discount_price');
    }


    public function getCart(): Cart
    {
        $userId = Auth::id();

        $cart = Cart::where('user_id', $userId)->where('product_order', 'no')->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $userId,
                'product_order' => 'no',
            ]);
        }

        return $cart;
    }

    public function getCartItemCount(): int
    {
        $cart = $this->getCart();
        if (!$cart || !$cart->items) {
            return 0;
        }

        return $cart->items->sum('quantity');
    }
}
