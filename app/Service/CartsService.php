<?php

namespace App\Service;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartsService
{
    /**
     * Add product to cart
     *
     * @param int $productId
     * @param int $quantity
     * @return void
     */
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

    /**
     * Get cart for current user
     *
     * @return Cart
     */
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

    /**
     * Get total number of items in cart for current user
     *
     * @return int
     */
    public function getCartItemCount(): int
    {
        $cart = $this->getCart();
        if (!$cart || !$cart->items) {
            return 0;
        }

        return $cart->items->sum('quantity');
    }
}
