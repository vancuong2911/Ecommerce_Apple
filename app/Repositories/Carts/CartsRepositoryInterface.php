<?php

namespace App\Repositories\Carts;

use App\Repository\RepositoryInterface;

interface CartsRepositoryInterface
{
    public function getCartByUserId($userId);

    public function getCartsAmountByUserId($userId);

    public function getDiscountPriceByCouponCode($couponCode, $totalPrice);

    public function getTotalPriceByUserId($userId);

    public function getExtraCharges();

    public function getTotalExtraCharge();
}
