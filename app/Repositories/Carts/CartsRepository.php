<?php

namespace App\Repository\Carts;

use App\Models\Products;
use App\Repository\BaseRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class CartsRepository extends BaseRepository implements CartsRepositoryInterface
{
    public function getModel()
    {
        return Products::class;
    }

    public function addProductToCart($product) {
        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                $product->id => [
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => $product->price,
                    'image' => $product->image,
                ]
            ];
            session()->put('cart', $cart);
        } else {
            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += 1;
                session()->put('cart', $cart);
            } else {
                $cart[$product->id] = [
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => $product->price,
                    'image' => $product->image,
                ];
                session()->put('cart', $cart);
            }
        }
    }

    public function updateProductInCart($product) {
        $cart = session()->get('cart');

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $product->quantity;
            session()->put('cart', $cart);
        }
    }

    public function removeProductFromCart($productId) {
        $cart = session()->get('cart');

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
    }

    public function getCart() {
        return session()->get('cart');
    }

}
