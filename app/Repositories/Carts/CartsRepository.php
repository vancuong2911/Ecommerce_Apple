<?php

namespace App\Repositories\Carts;

use App\Models\Cart;
use App\Repositories\Carts\CartsRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CartsRepository implements CartsRepositoryInterface
{
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
        // dd($totalPrice);
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
}
