<?php

namespace App\Service;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Carts\CartsRepository;

class CartsService
{

    protected $cartRepository;

    public function __construct(CartsRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getCartData($userId)
    {
        $carts = $this->cartRepository->getCartByUserId($userId);

        $cartAmount = $this->cartRepository->getCartsAmountByUserId($userId);

        $couponCode = $this->cartRepository->getCouponCodeByUserId($userId);

        $total_price = $this->cartRepository->getTotalPriceByUserId($userId);
        // dd($total_price);

        $without_discount_price = $this->cartRepository->getWithoutDiscountPriceByUserId($userId);

        if ($couponCode != NULL) {
            $couponData = $this->cartRepository->getCouponDataByCode($couponCode);

            $discount_price = $this->cartRepository->couponDiscountPrice($total_price, $couponData);
            // dd($total_price);
            $total_price = $total_price - $discount_price;
        } else {
            $discount_price = 0;
        }

        $extra_charge = $this->cartRepository->getExtraCharges();

        $total_extra_charge = $this->cartRepository->getTotalExtraCharge();

        return compact('carts', 'total_price', 'discount_price', 'cartAmount', 'extra_charge', 'total_extra_charge', 'without_discount_price');
    }

    public function addToCart(int $productId, int $quantity = 1): void
    {
        $product = Product::find($productId);

        if (!$product) {
            return;
        }

        $cart = $this->getCart();

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }
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
