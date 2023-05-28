<?php

namespace App\Repositories\Carts;

use App\Models\Cart;
use App\Repositories\Carts\CartsRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CartsRepository implements CartsRepositoryInterface
{
    public function getCartById($id)
    {
        return Cart::find($id);
    }
    public function getProductbyUserId()
    {
        return DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->get();
    }
    public function updateCartQuantity($productId, $userId, $quantity, $productPrice)
    {
        DB::table('carts')
            ->where('product_id', '=', $productId)
            ->where('user_id', $userId)
            ->where('product_order', 'no')
            ->update([
                'quantity' => $quantity,
                'subtotal' => $quantity * $productPrice
            ]);
    }
    public function getRates()
    {
        return DB::table('rates')
            ->join('users', 'rates.user_id', '=', 'users.id')
            ->select('rates.*', 'users.name')
            ->get();
    }

    public function getAllRates()
    {
        return DB::table('rates')->get();
    }

    public function createCart($productId, $userId, $quantity, $productPrice, $product)
    {
        DB::table('carts')->insert([
            'product_id' => $productId,
            'user_id' => $userId,
            'product_order' => "no",
            'shipping_address' => 'N/A',
            'name' => $product->name,
            'price' => $productPrice,
            'quantity' => $quantity,
            'subtotal' => $quantity * $productPrice,
        ]);
    }

    public function getCartQuantity($productId, $userId)
    {
        return DB::table('carts')
            ->where('product_id', $productId)
            ->where('user_id', $userId)
            ->where('product_order', 'no')
            ->value('quantity');
    }

    public function getCartByUserId($userId)
    {
        return Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->where('carts.user_id', $userId)
            ->where('carts.product_order', 'no')
            ->select('carts.*', 'products.image')
            ->get();
    }

    public function getCartsAmountByUserId($userId)
    {
        return DB::table('carts')
            ->where('user_id', $userId)
            ->where('product_order', 'no')
            ->count();
    }

    public function getCouponCodeByUserId($userId)
    {
        $cart = Cart::where('user_id', $userId)
            ->where('product_order', 'no')
            ->first();

        if ($cart) {
            return $cart->coupon_id;
        }

        return null;
    }

    public function getDiscountPriceByCouponCode($couponCode, $totalPrice)
    {
        $validate = DB::table('coupons')->where('code', $couponCode)->value('validate');
        $today = date("Y-m-d");

        if ($validate < $today) {
            return 0;
        } else {
            $couponCodePrice = DB::table('coupons')->where('code', $couponCode)->value('percentage');
            $discountPrice = (($totalPrice * $couponCodePrice) / 100);
            return floor($discountPrice);
        }
    }

    public function getTotalPriceByUserId($userId)
    {
        return DB::table('carts')
            ->where('user_id', $userId)
            ->where('product_order', 'no')
            ->sum('subtotal');
    }

    public function getCouponDataByCode($couponCode)
    {
        return DB::table('coupons')->where('code', $couponCode)
            ->first();
    }

    public function applyCouponDiscount($totalPrice, $couponData)
    {
        if ($couponData != null) {
            $validate = $couponData->validate;
            $today = date("Y-m-d");

            if ($validate >= $today) {
                $couponPercentage = $couponData->percentage;
                // dd($couponPercentage);
                $discountPrice = (($totalPrice * $couponPercentage) / 100);
                $discountPrice = floor($discountPrice);

                $totalPrice = floatval($totalPrice);
                $discountPrice = floatval($discountPrice);

                $totalPrice = $totalPrice - $discountPrice;
                $totalPrice = number_format($totalPrice, 2, '.', '');
            }
        }
        return $totalPrice;
    }

    public function couponDiscountPrice($totalPrice, $couponData)
    {
        // dd($totalPrice);
        if ($couponData != null) {
            $validate = $couponData->validate;
            $today = date("Y-m-d");

            if ($validate >= $today) {
                $couponPercentage = $couponData->percentage;
                // dd($couponPercentage);
                $discountPrice = (($totalPrice * $couponPercentage) / 100);
                $discountPrice = floor($discountPrice);

                $discountPrice = floatval($discountPrice);
                $discountPrice = number_format($discountPrice, 2, '.', '');
            }
        }
        return $discountPrice;
    }

    public function getWithoutDiscountPriceByUserId(int $userId): int
    {
        return DB::table('carts')
            ->where('user_id', $userId)
            ->where('product_order', 'no')
            ->sum('subtotal');
    }

    public function getExtraCharges()
    {
        return DB::table('charges')->get();
    }

    public function getTotalExtraCharge()
    {
        return DB::table('charges')->sum('price');
    }

    public function getPendingOrderCount(): int
    {
        return DB::table('carts')
            ->where('product_order', 'yes')
            ->groupBy('invoice_no')
            ->count();
    }

    public function getProcessingOrderCount(): int
    {
        return DB::table('carts')
            ->where('product_order', 'approve')
            ->groupBy('invoice_no')
            ->count();
    }

    public function getCancelledOrderCount(): int
    {
        return DB::table('carts')
            ->where('product_order', 'cancel')
            ->groupBy('invoice_no')
            ->count();
    }

    public function getCompleteOrderCount(): int
    {
        return DB::table('carts')
            ->where('product_order', 'delivery')
            ->groupBy('invoice_no')
            ->count();
    }

    public function getTotal(): float
    {
        return DB::table('carts')->where('product_order', 'yes')->sum('subtotal');
    }

    public function getCashOnDeliveryTotal(): float
    {
        return DB::table('carts')
            ->where('pay_method', 'Cash On Delivery')
            ->sum('subtotal');
    }

    public function getOnlinePaymentTotal(): float
    {
        return $this->getTotal() - $this->getCashOnDeliveryTotal();
    }
}
